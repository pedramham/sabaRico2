<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CategoryContentType;
use App\Entity\CategoryContent;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class CategoryContentController extends AbstractController
{
    /**
     * @Route("/admin_Cp/indexCategoryContent",name="indexCategoryContent")
     */
    public function indexCategoryContentAction()
    {
        return $this->render('AdminPanel/CategoryContent/index_category_content.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/admin_Cp/newCategoryContent",name="newCategoryContent")
     */
    public function newCategoryContentAction(Request $request,FileUploader $fileUploader)
    {
        $CategoryContent = new CategoryContent();
        $form = $this->createForm(CategoryContentType::class,$CategoryContent ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newCategoryContent'),
            [
                'name'        => null,
                'title'       => null,
                'subject'     => null,
                'description' => null,
                'descriptionSeo'  => null,
                'smallPic'        => null,
                'largePic'         => null,
                'urlSlug'         => null,
                'labelKeyWord'    => null,
                'displayStatus'   => null,
            ]
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $CategoryContent->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $CategoryContent->setSmallPic($smallPic);

            ////////////largePic///////////
            $fileLargePic = $CategoryContent->getLargePic();
            $largePic = $fileUploader->uploadArticlePic($fileLargePic);
            $CategoryContent->setLargePic($largePic);
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
            return $this->redirectToRoute('listCategoryContent');
        }
        return $this->render('AdminPanel/CategoryContent/new_category_content.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/editCategoryContent/{id}",name="editCategoryContent")
     */
    public function editCategoryContentAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:CategoryContent');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $CategoryContent = new CategoryContent();
        $form = $this->createForm(CategoryContentType::class,$CategoryContent,array(
            'action' => $this->generateUrl('editCategoryContent',array('id' => $categoryData->getId())),
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
                'displayStatus'   => $categoryData->getDisplayStatus(),

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
            return $this->redirectToRoute('listCategoryContent');

        }
        return $this->render('AdminPanel/CategoryContent/edit_category_content.html.twig', array(
            'form' => $form->createView(),
            'CategoryContent' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listCategoryContent",name="listCategoryContent")

     */
    public function listCategoryAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:CategoryContent');
        $Category = $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
        return $this->render('AdminPanel/CategoryContent/list_category.html.twig', array(
            'Categorys' => $Category
        ));
    }
    /**
     * @Route("/admin_Cp/News/deleteCategoryContent/{id}",name="deleteCategoryContent")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:CategoryContent');
        $category = $categoryRe->find($id);

        ////////ArticleCHeck/////////////
        $repositoryContent = $this->getDoctrine()
            ->getRepository('App:Content');
        $queryContent=   $repositoryContent->createQueryBuilder('n')
            ->Where('n.idCategory = :idCategory')
            ->setParameter('idCategory',$id)
            ->getQuery();
        $ContentRelate = $queryContent->getResult();
        if ($ContentRelate != null){
            $em->flush();
            $this->addFlash(
                'success',
                'این فهرست دارای مقاله است لطفا ابتدا مقالات مربوط به این فهرست را پاک کنید'
            );
            return $this->redirectToRoute('listCategoryContent');
        }
        if(is_null($category)){
            throw $this->createNotFoundException("No Article Found for id : ",$id);
        }
        $filePatch2 = $category->getLargePic();
        $filePatch = $category->getSmallPic();
        $fileUploader->deleteFileArticle($filePatch2);
        $fileUploader->deleteFileArticle($filePatch);
        $em->remove($category);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listCategoryContent');
    }
}
