<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CategoryProductType;
use App\Entity\CategoryProduct;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class CategoryProductController extends AbstractController
{
    /**
     * @Route("/admin_Cp/indexCategoryProduct",name="indexCategoryProduct")
     */
    public function indexCategoryProductAction()
    {
        return $this->render('AdminPanel/CategoryProduct/index_category_product.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/admin_Cp/newCategoryProduct",name="newCategoryProduct")
     */
    public function newCategoryProductAction(Request $request,FileUploader $fileUploader)
    {
        $CategoryProduct = new CategoryProduct();
        $form = $this->createForm(CategoryProductType::class,$CategoryProduct ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newCategoryProduct'),
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
                'idCategoryGeneralProduct'   => null,
            ]
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $CategoryProduct->getSmallPic();
            $smallPic = $fileUploader->uploadProductPic($file);
            $CategoryProduct->setSmallPic($smallPic);

            ////////////largePic///////////
            $fileLargePic = $CategoryProduct->getLargePic();
            $largePic = $fileUploader->uploadProductPic($fileLargePic);
            $CategoryProduct->setLargePic($largePic);
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
            return $this->redirectToRoute('listCategoryProduct');
        }
        return $this->render('AdminPanel/CategoryProduct/new_category_product.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/editCategoryProduct/{id}",name="editCategoryProduct")
     */
    public function editCategoryProductAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:CategoryProduct');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $CategoryProduct = new CategoryProduct();
        $form = $this->createForm(CategoryProductType::class,$CategoryProduct,array(
            'action' => $this->generateUrl('editCategoryProduct',array('id' => $categoryData->getId())),
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
                'idCategoryGeneralProduct'   => $categoryData->getIdCategoryGeneralProduct(),

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
            $categoryData->setIdCategoryGeneralProduct($form->get('idCategoryGeneralProduct')->getData());

            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $categoryData->getSmallPic();
                $fileUploader->deleteFile($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadProductPic($file);
                $categoryData->setSmallPic($smallPic);
            }
            ///////////////largePic///////
            if($form->get('largePic')->getData() != ""){
                $filePatchLargePic = $categoryData->getLargePic();
                $fileUploader->deleteFile($filePatchLargePic);
                $file = $form->get('largePic')->getData();
                $largePic = $fileUploader->uploadProductPic($file);
                $categoryData->setLargePic($largePic);
            }
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listCategoryProduct');

        }
        return $this->render('AdminPanel/CategoryProduct/edit_category_product.html.twig', array(
            'form' => $form->createView(),
            'CategoryProduct' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listCategoryProduct",name="listCategoryProduct")

     */
    public function listCategoryAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:CategoryProduct');
        $Category = $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
        return $this->render('AdminPanel/CategoryProduct/list_category.html.twig', array(
            'Categorys' => $Category
        ));
    }
    /**
     * @Route("/admin_Cp/News/deleteCategoryProduct/{id}",name="deleteCategoryProduct")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:CategoryProduct');
        $category = $categoryRe->find($id);

        ////////ArticleCHeck/////////////
        $repositoryArticle = $this->getDoctrine()
            ->getRepository('App:Product');
        $queryArticle=   $repositoryArticle->createQueryBuilder('n')
            ->Where('n.idCategoryProduct = :idCategoryProduct')
            ->setParameter('idCategoryProduct',$id)
            ->getQuery();
        $ArticleRelate = $queryArticle->getResult();
        if ($ArticleRelate != null){
            $em->flush();
            $this->addFlash(
                'success',
                'این فهرست دارای محصول است لطفا ابتدا محصولات مربوط به این فهرست را پاک کنید'
            );
            return $this->redirectToRoute('listCategoryProduct');
        }
        if(is_null($category)){
            throw $this->createNotFoundException("No Product Found for id : ",$id);
        }
        $filePatch2 = $category->getLargePic();
        $filePatch = $category->getSmallPic();
        $fileUploader->deleteFile($filePatch2);
        $fileUploader->deleteFile($filePatch);
        $em->remove($category);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listCategoryProduct');
    }
}
