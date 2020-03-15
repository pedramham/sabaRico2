<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CategoryServiceType;
use App\Entity\CategoryService;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class CategoryServiceController extends AbstractController
{
    /**
     * @Route("/admin_Cp/indexCategorySevice",name="indexCategoryService")
     */
    public function indexCategoryServiceAction()
    {
        return $this->render('AdminPanel/CategoryService/index_category_service.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/admin_Cp/newCategoryService",name="newCategoryService")
     */
    public function newCategoryServiceAction(Request $request,FileUploader $fileUploader)
    {
        $CategoryService = new CategoryService();
        $form = $this->createForm(CategoryServiceType::class,$CategoryService ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newCategoryService'),
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
                'panelLastCatService' => null,
            ]
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $CategoryService->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $CategoryService->setSmallPic($smallPic);

            ////////////largePic///////////
            $fileLargePic = $CategoryService->getLargePic();
            $largePic = $fileUploader->uploadArticlePic($fileLargePic);
            $CategoryService->setLargePic($largePic);
            ///////////////////////////

            ///////////////////////////
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'فهرست جدید اضافه شد'
            );
            return $this->redirectToRoute('listCategoryService');
        }
        return $this->render('AdminPanel/CategoryService/new_category_service.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/editCategoryService/{id}",name="editCategoryService")
     */
    public function editCategoryServiceAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:CategoryService');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $CategoryService = new CategoryService();
        $form = $this->createForm(CategoryServiceType::class,$CategoryService,array(
            'action' => $this->generateUrl('editCategoryService',array('id' => $categoryData->getId())),
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
                'panelLastCatService' => $categoryData->getPanelLastCatService(),

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
            $categoryData->setPanelLastCatService($form->get('panelLastCatService')->getData());

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
            return $this->redirectToRoute('listCategoryService');

        }
        return $this->render('AdminPanel/CategoryService/edit_category_service.html.twig', array(
            'form' => $form->createView(),
            'CategoryService' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listCategoryService",name="listCategoryService")

     */
    public function listCategoryAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:CategoryService');
        $Category = $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
        return $this->render('AdminPanel/CategoryService/list_category.html.twig', array(
            'Categorys' => $Category
        ));
    }
    /**
     * @Route("/admin_Cp/Service/deleteCategoryService/{id}",name="deleteCategoryService")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:CategoryService');
        $category = $categoryRe->find($id);

        ////////ArticleCHeck/////////////
        $repositoryService = $this->getDoctrine()
            ->getRepository('App:Service');
        $queryService=   $repositoryService->createQueryBuilder('n')
            ->Where('n.idCategory = :idCategory')
            ->setParameter('idCategory',$id)
            ->getQuery();
        $ServiceRelate = $queryService->getResult();
        if ($ServiceRelate != null){
            $em->flush();
            $this->addFlash(
                'success',
                'این فهرست دارای مقاله است لطفا ابتدا مقالات مربوط به این فهرست را پاک کنید'
            );
            return $this->redirectToRoute('listCategoryService');
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
        return $this->redirectToRoute('listCategoryService');
    }

    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('Service×By*××id−−×1');
        $cacheDriver->delete('Service×By*××limit−−××2');
        $cacheDriver->delete('Service×By*××relate−−×××3');
        $cacheDriver->delete('categoryService−×××−−×1');
    }
}
