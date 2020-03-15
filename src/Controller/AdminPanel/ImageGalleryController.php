<?php

namespace App\Controller\AdminPanel;
use App\Entity\Article;
use App\Entity\ImageGallery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ImageGalleryType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;

class ImageGalleryController extends AbstractController
{
    /**
     * @Route("/admin_Cp/newImageGalley/{id}",name="newImageGalley")
     */
    public function newImageGalleyAction($id,Request $request,FileUploader $fileUploader)
    {
        $ImageGallery = new ImageGallery();
        $form = $this->createForm(ImageGalleryType::class,$ImageGallery ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newImageGalley',array('id' => $id)),
            [
                'name'          => null,
                'title'         => null,
                'subject'       => null,
                'file'          => null,
                'alt'           => null,
                'displayStatus' => null,
                'displayPriority' => null,
                ]
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ////////////smallPic///////////
            $file = $ImageGallery->getFile();
            $file = $fileUploader->uploadImageGallery($file);
            $ImageGallery->setFile($file);
            $Article = $this->getDoctrine()->getManager()->getRepository('App:Article')->find($id);
            $ImageGallery->setIdArticle($Article);
            ///////////////////////////
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $em->persist($data);
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'تصویر  جدید اضافه شد.'
            );
            return $this->redirectToRoute('listImagesGallery',array('id' => $id));
        }
        return $this->render('AdminPanel/ImagesGallery/new_image_gallery.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/admin_Cp/listArticleImagesGallery",name="listArticleImagesGallery")
     */
    public function listArticleImagesGalleryAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleyRepository = $em->getRepository(Article::class);
        $allArticleQuery = $imageGalleyRepository->createQueryBuilder('i')
            ->orderBy('i.dateInsert', 'DESC')
            ->getQuery();

        $article = $paginator->paginate(
            $allArticleQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGallery/list_article_image_gallery.html.twig', array(
            'Articles' => $article
        ));
    }
    /**
     * @Route("/admin_Cp/listImagesGallery/{id}",name="listImagesGallery")
     */
    public function listImagesGalleryAction($id,Request $request,PaginatorInterface $paginator)
    {
        $imageGalleyRepository = $this->getDoctrine()->getManager()->getRepository(ImageGallery::class);
        if ($id == 0){
            $allArticleQuery = $imageGalleyRepository->createQueryBuilder('i')
                ->orderBy('i.dateInsert', 'DESC')
                ->getQuery();
        }else{
            $allArticleQuery = $imageGalleyRepository->createQueryBuilder('i')
                ->where("i.idArticle = :idArticle")
                ->orderBy('i.dateInsert', 'DESC')
                ->setParameter('idArticle', $id)
                ->getQuery();
        }

        $articleImage = $paginator->paginate(
            $allArticleQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGallery/list_image_gallery.html.twig', array(
            'ArticleImages' => $articleImage,
            "idArticleEmpty" => $id,
        ));
    }

    /**
     * @Route("/admin_Cp/ImagesGallery/editImagesGallery/{id}",name="editImagesGallery")
     */
    public function editImagesGalleryAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleryRepo=$em->getRepository('App:ImageGallery');
        $imageGalleryData = $imageGalleryRepo->find($id);
        $ImageGallery = new ImageGallery();

        $form = $this->createForm(ImageGalleryType::class,$ImageGallery,array(
            'action' => $this->generateUrl('editImagesGallery',array('id' => $imageGalleryData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'           => $imageGalleryData->getName(),
                'title'          => $imageGalleryData->getTitle(),
                'subject'        => $imageGalleryData->getSubject(),
                'file'           => $imageGalleryData->getFile(),
                'alt'            => $imageGalleryData->getAlt(),
                'displayStatus'  => $imageGalleryData->getDisplayStatus(),
                'displayPriority'  => $imageGalleryData->getDisplayPriority(),
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);

            $imageGalleryData->setName($form->get('name')->getData());
            $imageGalleryData->setTitle($form->get('title')->getData());
            $imageGalleryData->setSubject($form->get('subject')->getData());
            $imageGalleryData->setAlt($form->get('alt')->getData());
            $imageGalleryData->setDisplayStatus($form->get('displayStatus')->getData());
            $imageGalleryData->setDisplayPriority($form->get('displayPriority')->getData());
            /////smallPic/////////////////////////
            if($form->get('file')->getData() != ""){
                $filePatch = $imageGalleryData->getFile();
                $fileUploader->deleteImageGallery($filePatch);
                $file = $form->get('file')->getData();
                $smallPic = $fileUploader->uploadImageGallery($file);
                $imageGalleryData->setFile($smallPic);
            }
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listImagesGallery',array('id' => $imageGalleryData->getIdArticle()->getId()));
        }
        return $this->render('AdminPanel/ImagesGallery/edit_image_gallery.html.twig', array(
            'form' => $form->createView(),
            'imageGalleryData' => $imageGalleryData,
        ));
    }
    /**
     * @Route("/admin_Cp/ImagesGallery/deleteImagesGallery/{id}/{idArticle}",name="deleteImagesGallery")
     *
     */
    public function deleteImagesGallery($idArticle,Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:ImageGallery');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No News Found for id : ",$id);
        }
        $filePatch2 = $category->getFile();
        $fileUploader->deleteImageGallery($filePatch2);
        $em->remove($category);
        //delete cache redis
        $this->deleteCacheAfterChangeDataBase($em);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listImagesGallery',array('id' => $idArticle));
    }
    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('imageGallery*××find−−×××3');

    }
}
