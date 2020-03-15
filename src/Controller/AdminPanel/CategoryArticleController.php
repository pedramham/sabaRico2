<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CategoryArticleType;
use App\Entity\CategoryArticle;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class CategoryArticleController extends AbstractController
{
    /**
     * @Route("/admin_Cp/indexCategoryArticle",name="indexCategoryArticle")
     */
    public function indexCategoryArticleAction()
    {
        return $this->render('AdminPanel/CategoryArticle/index_category_article.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/admin_Cp/newCategoryAericle",name="newCategoryArticle")
     */
    public function newCategoryNewsAction(Request $request,FileUploader $fileUploader)
    {
        $CategoryArticle = new CategoryArticle();
        $form = $this->createForm(CategoryArticleType::class,$CategoryArticle ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newCategoryArticle'),
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
                'displayStatus'   => null,
                'panelMainPageTopArticle' => null,
            ]
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $CategoryArticle->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $CategoryArticle->setSmallPic($smallPic);

            ////////////largePic///////////
            $fileLargePic = $CategoryArticle->getLargePic();
            $largePic = $fileUploader->uploadArticlePic($fileLargePic);
            $CategoryArticle->setLargePic($largePic);
            ///////////////////////////

            ///////////////////////////
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $this->addFlash(
                'success',
                'فهرست جدید اضافه شد'
            );
            return $this->redirectToRoute('listCategoryArticle');
        }
        return $this->render('AdminPanel/CategoryArticle/new_category_article.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/editCategoryArticle/{id}",name="editCategoryArticle")
     */
    public function editCategoryArticleAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:CategoryArticle');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $CategoryArticle = new CategoryArticle();
        $form = $this->createForm(CategoryArticleType::class,$CategoryArticle,array(
            'action' => $this->generateUrl('editCategoryArticle',array('id' => $categoryData->getId())),
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
                'panelMainPageTopArticle' => $categoryData->getPanelMainPageTopArticle(),

            ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){
            $form->handleRequest($request);
//            var_dump($form->get('description')->getData());
//            die();
            $categoryData->setName($form->get('name')->getData());
            $categoryData->setTitle($form->get('title')->getData());
            $categoryData->setSubject($form->get('subject')->getData());
            $categoryData->setDescription($form->get('description')->getData());
            $categoryData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $categoryData->setDisplayStatus($form->get('displayStatus')->getData());
            $categoryData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $categoryData->setUrlSlug($form->get('urlSlug')->getData());
            $categoryData->setPanelMainPageTopArticle($form->get('panelMainPageTopArticle')->getData());

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
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listCategoryArticle');

        }
        return $this->render('AdminPanel/CategoryArticle/edit_category_article.html.twig', array(
            'form' => $form->createView(),
            'CategoryArticle' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listCategoryArticle",name="listCategoryArticle")

     */
    public function listCategoryAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:CategoryArticle');
        $Category = $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
        return $this->render('AdminPanel/CategoryArticle/list_category.html.twig', array(
            'Categorys' => $Category
        ));
    }
    /**
     * @Route("/admin_Cp/News/deleteCategoryArticle{id}",name="deleteCategoryArticle")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:CategoryArticle');
        $category = $categoryRe->find($id);

        ////////ArticleCHeck/////////////
        $repositoryArticle = $this->getDoctrine()
            ->getRepository('App:Article');
        $queryArticle=   $repositoryArticle->createQueryBuilder('n')
            ->Where('n.idCategory = :idCategory')
            ->setParameter('idCategory',$id)
            ->getQuery();
        $ArticleRelate = $queryArticle->getResult();
        if ($ArticleRelate != null){
            $em->flush();
            $this->addFlash(
                'success',
                'این فهرست دارای مقاله است لطفا ابتدا مقالات مربوط به این فهرست را پاک کنید'
            );
            return $this->redirectToRoute('listCategoryArticle');
        }
        if(is_null($category)){
            throw $this->createNotFoundException("No Article Found for id : ",$id);
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
        return $this->redirectToRoute('listCategoryArticle');
    }

    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('Article××−−By××Id×××−1');
        $cacheDriver->delete('Article××−−By××Limit×××−2');
        $cacheDriver->delete('Article××−−By××Except×××id−3');
        $cacheDriver->delete('Article××−−By××Except×××id××××cat−3');
        $cacheDriver->delete('CategoryArticle×××−−×1');
    }
}
