<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CategoryVideoType;
use App\Entity\CategoryVideo;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class CategoryVideoController extends AbstractController
{
    /**
     * @Route("/admin_Cp/indexCategoryVideo",name="indexCategoryVideo")
     */
    public function indexCategoryVideoAction()
    {
        return $this->render('AdminPanel/CategoryVideo/index_category_video.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/admin_Cp/newCategoryVideo",name="newCategoryVideo")
     */
    public function newCategoryVideoAction(Request $request,FileUploader $fileUploader)
    {
        $CategoryVideo = new CategoryVideo();
        $form = $this->createForm(CategoryVideoType::class,$CategoryVideo ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newCategoryVideo'),
            [
                'name'        => null,
                'title'       => null,
                'subject'     => null,
                'description' => null,
                'descriptionSeo'  => null,
                'smallPic'        => null,
                'largePic'        => null,
                'urlSlug'         => null,
                'labelKeyWord'    => null,
                'authorName'      => null,
                'displayStatus'   => null,
                'displayPriority' => null,
                'codeColorBrand'  => null,
            ]
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $CategoryVideo->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $CategoryVideo->setSmallPic($smallPic);
            ////////////largePic///////////
            $fileLargePic = $CategoryVideo->getLargePic();
            $largePic = $fileUploader->uploadArticlePic($fileLargePic);
            $CategoryVideo->setLargePic($largePic);
            ///////////////////////////
            ///////////////////////////
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->addFlash(
                'success',
                'فهرست جدید اضافه شد'
            );
            return $this->redirectToRoute('listCategoryVideo');
        }
        return $this->render('AdminPanel/CategoryVideo/new_category_video.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/admin_Cp/editCategoryVideo/{id}",name="editCategoryVideo")
     */
    public function editCategoryVideoAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:CategoryVideo');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $CategoryVideo = new CategoryVideo();
        $form = $this->createForm(CategoryVideoType::class,$CategoryVideo,array(
            'action' => $this->generateUrl('editCategoryVideo',array('id' => $categoryData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'          => $categoryData->getName(),
                'title'         => $categoryData->getTitle(),
                'subject'       => $categoryData->getSubject(),
                'description'   => $categoryData->getDescription(),
                'descriptionSeo'  => $categoryData->getDescriptionSeo(),
                'smallPic'        => $categoryData->getSmallPic(),
                'largePic'         => $categoryData->getLargePic(),
                'labelKeyWord'    => $categoryData->getLabelKeyWord(),
                'urlSlug'         => $categoryData->getUrlSlug(),
                'authorName'      => $categoryData->getAuthorName(),
                'displayStatus'   => $categoryData->getDisplayStatus(),
                'codeColorBrand'  => $categoryData->getCodeColorBrand(),
            ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){
            $form->handleRequest($request);
            $categoryData->setName($form->get('name')->getData());
            $categoryData->setTitle($form->get('title')->getData());
            $categoryData->setSubject($form->get('subject')->getData());
            $categoryData->setDescription($form->get('description')->getData());
            $categoryData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $categoryData->setDisplayStatus($form->get('displayStatus')->getData());
            $categoryData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $categoryData->setUrlSlug($form->get('urlSlug')->getData());
            $categoryData->setAuthorName($form->get('authorName')->getData());
            $categoryData->setCodeColorBrand($form->get('codeColorBrand')->getData());

            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $categoryData->getSmallPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadArticlePic($file);
                $categoryData->setSmallPic($smallPic);
            }
            ///////////////largePic///////
            if($form->get('largePic')->getData() != ""){
                $filePatchLargePic = $categoryData->getLargePic();
                $fileUploader->deleteFileArticle($filePatchLargePic);
                $file = $form->get('largePic')->getData();
                $largePic = $fileUploader->uploadArticlePic($file);
                $categoryData->setLargePic($largePic);
            }
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listCategoryVideo');

        }
        return $this->render('AdminPanel/CategoryVideo/edit_category_video.html.twig', array(
            'form' => $form->createView(),
            'CategoryVideo' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listCategoryVideo",name="listCategoryVideo")

     */
    public function listCategoryVideoAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:CategoryVideo');
        $Category = $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
        return $this->render('AdminPanel/CategoryVideo/list_category_video.html.twig', array(
            'Categorys' => $Category
        ));
    }



    /**
     * @Route("/admin_Cp/Video/deleteCategoryVideo/{id}",name="deleteCategoryVideo")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:CategoryVideo');
        $category = $categoryRe->find($id);

        ////////VideoCHeck/////////////
        $repositoryVideo = $this->getDoctrine()
            ->getRepository('App:Video');
        $queryVideo=   $repositoryVideo->createQueryBuilder('n')
            ->Where('n.idCategory = :idCategory')
            ->setParameter('idCategory',$id)
            ->getQuery();
        $VideoRelate = $queryVideo->getResult();
        if ($VideoRelate != null){
            $em->flush();
            $this->addFlash(
                'success',
                'این فهرست دارای ویدیو است لطفا ابتدا ویدویو مربوط به این فهرست را پاک کنید'
            );
            return $this->redirectToRoute('listCategoryVideo');
        }
        if(is_null($category)){
            throw $this->createNotFoundException("No Article Found for id : ",$id);
        }
        $filePatch = $category->getSmallPic();
        $fileUploader->deleteFileArticle($filePatch);
        $em->remove($category);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listCategoryVideo');
    }
}
