<?php

namespace App\Controller\AdminPanel;
use App\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ContentType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;

class ContentController extends AbstractController
{


    /**
     * @Route("/admin_Cp/newContent",name="newContent")
     */
    public function newContentAction(Request $request,FileUploader $fileUploader)
    {
        $Content = new Content();
        $form = $this->createForm(ContentType::class,$Content ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newContent'),
            [
                'name'           => null,
                'title'          => null,
                'subject'        => null,
                'description'    => null,
                'descriptionSeo' => null,
                'smallPic'       => null,
                'largePic'       => null,
                'idCategory'     => null,
                'labelKeyWord'   => null,
                'urlSlug'        => null,
                'authorName'     => null,
                'displayStatus'  => null,
                'panelContent'   => null,

                ]
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $Content->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $Content->setSmallPic($smallPic);

            ////////////largePic///////////
            $file = $Content->getLargePic();
            $largePic = $fileUploader->uploadArticlePic($file);
            $Content->setLargePic($largePic);
            ///////////////////////////
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'مقالات  جدید اضافه شد.'
            );
            return $this->redirectToRoute('listContent');

        }
        return $this->render('AdminPanel/Content/new_content.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/Content/editContent/{id}",name="editContent")
     */
    public function editContentAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $contentRepo=$em->getRepository('App:Content');
        $contentData = $contentRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $Content = new Content();
        $form = $this->createForm(ContentType::class,$Content,array(
            'action' => $this->generateUrl('editContent',array('id' => $contentData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'           => $contentData->getName(),
                'title'          => $contentData->getTitle(),
                'subject'        => $contentData->getSubject(),
                'description'    => $contentData->getDescription(),
                'descriptionSeo' => $contentData->getDescriptionSeo(),
                'smallPic'       => $contentData->getSmallPic(),
                'largePic'       => $contentData->getLargePic(),
                'idCategory'     => $contentData->getIdCategory(),
                'labelKeyWord'   => $contentData->getLabelKeyWord(),
                'urlSlug'        => $contentData->getUrlSlug(),
                'authorName'     => $contentData->getAuthorName(),
                'displayStatus'  => $contentData->getDisplayStatus(),
                'panelContent'   => $contentData->getPanelContent(),
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);
            $data = $form->getData();
            $contentData->setName($form->get('name')->getData());
            $contentData->setTitle($form->get('title')->getData());
            $contentData->setSubject($form->get('subject')->getData());
            $contentData->setDescription($form->get('description')->getData());
            $contentData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $contentData->setDisplayStatus($form->get('displayStatus')->getData());
            $contentData->setIdCategory($form->get('idCategory')->getData());
            $contentData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $contentData->setUrlSlug($form->get('urlSlug')->getData());
            $contentData->setAuthorName($form->get('authorName')->getData());
            $contentData->setPanelContent($form->get('panelContent')->getData());
            $contentData->setLastUpdate(new \DateTime());
            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $contentData->getSmallPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadArticlePic($file);
                $contentData->setSmallPic($smallPic);
            }
            ///////////////largePic///////
            if($form->get('largePic')->getData() != ""){
                $filePatch = $contentData->getLargePic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('largePic')->getData();
                $largePic = $fileUploader->uploadArticlePic($file);
                $contentData->setLargePic($largePic);
            }

            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listContent');
        }
        return $this->render('AdminPanel/Content/edit_content.html.twig', array(
            'form' => $form->createView(),
            'Content' => $contentData
        ));
    }

    /**
     * @Route("/admin_Cp/listContent",name="listContent")
     */
    public function listContentAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $contentRepository = $em->getRepository(Content::class);
        $allContentQuery = $contentRepository->createQueryBuilder('n')
            ->orderBy('n.dateInsert', 'DESC')
//            ->setParameter('status', 'canceled')
            ->getQuery();

        $content = $paginator->paginate(
            $allContentQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/Content/list_content.html.twig', array(
            'Contents' => $content
        ));
    }

    /**
     * @Route("/admin_Cp/Content/deleteContent/{id}",name="deleteContent‌")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:Content');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No News Found for id : ",$id);
        }
        $filePatch2 = $category->getLargePic();
        $filePatch = $category->getSmallPic();
        $fileUploader->deleteFileArticle($filePatch2);
        $fileUploader->deleteFileArticle($filePatch);
        $em->remove($category);

        ///delete Cache redis
        $this->deleteCacheAfterChangeDataBase($em);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listContent');
    }
    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('Content−×××−−3×5');
    }
}
