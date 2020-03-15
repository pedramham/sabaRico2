<?php

namespace App\Controller\AdminPanel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\ProductType;
use App\Entity\Product;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
class ProductController extends AbstractController
{
    /**
     * @Route("/admin_Cp/newProduct",name="newProduct")
     */
    public function newProductAction(Request $request,FileUploader $fileUploader)
    {
        $Product = new Product();
        $form = $this->createForm(ProductType::class,$Product ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newProduct'),
            [
                'name'        => null,
                'title'       => null,
                'subject'     => null,
                'description' => null,
                'descriptionSeo'  => null,
                'smallPic'        => null,
                'urlSlug'         => null,
                'labelKeyWord'    => null,
                'displayStatus'   => null,
                'idCategoryProduct' => null,
                'price'             => null,
                'discount'          => null,
                'brand'             => null,
                'guarantee'         => null,
                'periodGuarantee'   => null,
                'sellerTelephone'   => null,
                'panelLastProduct'  => null,
                'productCode'       => null,
                'companyImporter'   => null,
                'manufacturingCountry' => null,
            ]
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $Product->getSmallPic();
            $smallPic = $fileUploader->uploadProductPic($file);
            $Product->setSmallPic($smallPic);
            ///////////////////////////
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'محصول جدید اضافه شد'
            );
            return $this->redirectToRoute('listProduct');
        }
        return $this->render('AdminPanel/Product/new_product.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/editProduct/{id}",name="editProduct")
     */
    public function editProductAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo=$em->getRepository('App:Product');
        $categoryData = $categoryRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $Product = new Product();
        $form = $this->createForm(ProductType::class,$Product,array(
            'action' => $this->generateUrl('editProduct',array('id' => $categoryData->getId())),
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
                'labelKeyWord'    => $categoryData->getLabelKeyWord(),
                'urlSlug'         => $categoryData->getUrlSlug(),
                'displayStatus'   => $categoryData->getDisplayStatus(),
                'idCategoryProduct' => $categoryData->getIdCategoryProduct(),
                'price'     => $categoryData->getPrice(),
                'discount'  => $categoryData->getDiscount(),
                'brand'     => $categoryData->getBrand(),
                'guarantee' => $categoryData->getGuarantee(),
                'periodGuarantee'  => $categoryData->getPeriodGuarantee(),
                'sellerTelephone'  => $categoryData->getSellerTelephone(),
                'panelLastProduct' => $categoryData->getPanelLastProduct(),
                'productCode'      => $categoryData->getProductCode(),
                'companyImporter'  => $categoryData->getCompanyImporter(),
                'manufacturingCountry' => $categoryData->getManufacturingCountry(),

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
            $categoryData->setIdCategoryProduct($form->get('idCategoryProduct')->getData());

            $categoryData->setPrice($form->get('price')->getData());
            $categoryData->setDiscount($form->get('discount')->getData());
            $categoryData->setManufacturingCountry($form->get('manufacturingCountry')->getData());
            $categoryData->setBrand($form->get('brand')->getData());
            $categoryData->setGuarantee($form->get('guarantee')->getData());
            $categoryData->setPeriodGuarantee($form->get('periodGuarantee')->getData());
            $categoryData->setSellerTelephone($form->get('sellerTelephone')->getData());
            $categoryData->setPanelLastProduct($form->get('panelLastProduct')->getData());
            $categoryData->setProductCode($form->get('productCode')->getData());
            $categoryData->setCompanyImporter($form->get('companyImporter')->getData());

            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $categoryData->getSmallPic();
                $fileUploader->deleteFile($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadProductPic($file);
                $categoryData->setSmallPic($smallPic);
            }
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listProduct');

        }
        return $this->render('AdminPanel/Product/edit_product.html.twig', array(
            'form' => $form->createView(),
            'Product' => $categoryData
        ));
    }

    /**
     * @Route("/admin_Cp/listProduct",name="listProduct")

     */
    public function listProductAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository(Product::class);
        $allProductQuery = $productRepository->createQueryBuilder('p')
            ->orderBy('p.dateInsert', 'DESC')
//            ->setParameter('status', 'canceled')
            ->getQuery();

        $product = $paginator->paginate(
            $allProductQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/Product/list_product.html.twig', array(
            'Products' => $product
        ));
    }
    /**
     * @Route("/admin_Cp/Product/deleteProduct/{id}",name="deleteProduct")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:Product');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No Product Found for id : ",$id);
        }
        $filePatch = $category->getSmallPic();
        $fileUploader->deleteFile($filePatch);
        ///delete Cache redis
        $this->deleteCacheAfterChangeDataBase($em);
        $em->remove($category);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listProduct');
    }

    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('Product−××id×−−1×');
        $cacheDriver->delete('Product−××limit×−−2×');
        $cacheDriver->delete('Product−××except×−−3×');
    }
}
