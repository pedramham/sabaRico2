<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CategoryGeneralProductType;
use App\Entity\CategoryGeneralProduct;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class CategoryGeneralProductController extends AbstractController
{
    /**
     * @Route("/admin_Cp/indexCategoryGeneralProduct",name="indexCategoryGeneralProduct")
     */
    public function indexCategoryGeneralProductAction()
    {
        return $this->render('AdminPanel/CategoryGeneralProduct/index_category_general_product.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/admin_Cp/newCategoryGeneralProduct",name="newCategoryGeneralProduct")
     */
    public function newCategoryGeneralProductAction(Request $request,FileUploader $fileUploader)
    {
        $CategoryGeneralProduct = new CategoryGeneralProduct();
        $form = $this->createForm(CategoryGeneralProductType::class,$CategoryGeneralProduct ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newCategoryGeneralProduct'),
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
            $file = $CategoryGeneralProduct->getSmallPic();
            $smallPic = $fileUploader->uploadProductPic($file);
            $CategoryGeneralProduct->setSmallPic($smallPic);

            ////////////largePic///////////
            $fileLargePic = $CategoryGeneralProduct->getLargePic();
            $largePic = $fileUploader->uploadProductPic($fileLargePic);
            $CategoryGeneralProduct->setLargePic($largePic);
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
            return $this->redirectToRoute('listCategoryGeneralProduct');
        }
        return $this->render('AdminPanel/CategoryGeneralProduct/new_category_general_product.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/editCategoryGeneralProduct/{id}",name="editCategoryGeneralProduct")
     */
    public function editCategoryGeneralProductAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:CategoryGeneralProduct');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $CategoryGeneralProduct = new CategoryGeneralProduct();
        $form = $this->createForm(CategoryGeneralProductType::class,$CategoryGeneralProduct,array(
            'action' => $this->generateUrl('editCategoryGeneralProduct',array('id' => $categoryData->getId())),
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
            return $this->redirectToRoute('listCategoryGeneralProduct');

        }
        return $this->render('AdminPanel/CategoryGeneralProduct/edit_category_general_product.html.twig', array(
            'form' => $form->createView(),
            'CategoryGeneralProduct' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listCategoryGeneralProduct",name="listCategoryGeneralProduct")

     */
    public function listCategoryAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('App:CategoryGeneralProduct');
        $Category = $repository->findBy(
            array(),
            array('id' => 'DESC')
        );
        return $this->render('AdminPanel/CategoryGeneralProduct/list_category.html.twig', array(
            'Categorys' => $Category
        ));
    }
    /**
     * @Route("/admin_Cp/News/deleteCategoryGeneralProduct/{id}",name="deleteCategoryGeneralProduct")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:CategoryGeneralProduct');
        $category = $categoryRe->find($id);

        ////////ArticleCHeck/////////////
        $repositoryArticle = $this->getDoctrine()
            ->getRepository('App:CategoryProduct');
        $queryArticle=   $repositoryArticle->createQueryBuilder('n')
            ->Where('n.idCategoryGeneralProduct = :idCategoryGeneralProduct')
            ->setParameter('idCategoryGeneralProduct',$id)
            ->getQuery();
        $ArticleRelate = $queryArticle->getResult();
        if ($ArticleRelate != null){
            $em->flush();
            $this->addFlash(
                'success',
                'این فهرست دارای فهرست است لطفا ابتدا فهرست محصولات مربوط به این فهرست را پاک کنید'
            );
            return $this->redirectToRoute('listCategoryGeneralProduct');
        }
        if(is_null($category)){
            throw $this->createNotFoundException("No Category Product Found for id : ",$id);
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
        return $this->redirectToRoute('listCategoryGeneralProduct');
    }
}
