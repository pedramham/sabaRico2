<?php

namespace App\Controller\AdminPanel;
use App\Entity\Article;
use App\Entity\ImageGallery;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ImageGalleryType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;

class ImageGalleryProductController extends AbstractController
{
    /**
     * @Route("/admin_Cp/newImageGalleyProduct/{id}",name="newImageGalleyProduct")
     */
    public function newImageGalleyProductAction($id,Request $request,FileUploader $fileUploader)
    {
        $ImageGallery = new ImageGallery();
        $form = $this->createForm(ImageGalleryType::class,$ImageGallery ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newImageGalleyProduct',array('id' => $id)),
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
            $Product = $this->getDoctrine()->getManager()->getRepository('App:Product')->find($id);
            $ImageGallery->setIdProduct($Product);
            ///////////////////////////
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $em->persist($data);
            //delete cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'تصویر  جدید اضافه شد.'
            );
            return $this->redirectToRoute('listImagesGalleryProduct',array('id' => $id));
        }
        return $this->render('AdminPanel/ImagesGalleryProduct/new_image_gallery_product.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/admin_Cp/listProductImagesGallery",name="listProductImagesGallery")
     */
    public function listProductImagesGalleryAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleyRepository = $em->getRepository(Product::class);
        $allProductQuery = $imageGalleyRepository->createQueryBuilder('i')
            ->orderBy('i.dateInsert', 'DESC')
            ->getQuery();

        $product = $paginator->paginate(
            $allProductQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGalleryProduct/list_product_image_gallery.html.twig', array(
            'Products' => $product
        ));
    }
    /**
     * @Route("/admin_Cp/listImagesGalleryProduct/{id}",name="listImagesGalleryProduct")
     */
    public function listImagesGalleryProductAction($id,Request $request,PaginatorInterface $paginator)
    {
        $imageGalleyRepository = $this->getDoctrine()->getManager()->getRepository(ImageGallery::class);
        if ($id == 0){
            $allProductQuery = $imageGalleyRepository->createQueryBuilder('i')
                ->orderBy('i.dateInsert', 'DESC')
                ->getQuery();
        }else{
            $allProductQuery = $imageGalleyRepository->createQueryBuilder('i')
                ->where("i.idProduct = :idProduct")
                ->orderBy('i.dateInsert', 'DESC')
                ->setParameter('idProduct', $id)
                ->getQuery();
        }

        $productImage = $paginator->paginate(
            $allProductQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGalleryProduct/list_image_gallery_product.html.twig', array(
            'ProductImages' => $productImage,
            "idProductEmpty" => $id,
        ));
    }

    /**
     * @Route("/admin_Cp/ImagesGalleryProduct/editImagesGalleryProduct/{id}",name="editImagesGalleryProduct")
     */
    public function editImagesGalleryProductAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleryRepo=$em->getRepository('App:ImageGallery');
        $imageGalleryProductData = $imageGalleryRepo->find($id);
        $ImageGallery = new ImageGallery();

        $form = $this->createForm(ImageGalleryType::class,$ImageGallery,array(
            'action' => $this->generateUrl('editImagesGalleryProduct',array('id' => $imageGalleryProductData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'           => $imageGalleryProductData->getName(),
                'title'          => $imageGalleryProductData->getTitle(),
                'subject'        => $imageGalleryProductData->getSubject(),
                'file'           => $imageGalleryProductData->getFile(),
                'alt'            => $imageGalleryProductData->getAlt(),
                'displayStatus'  => $imageGalleryProductData->getDisplayStatus(),
                'displayPriority'=> $imageGalleryProductData->getDisplayPriority(),
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);

            $imageGalleryProductData->setName($form->get('name')->getData());
            $imageGalleryProductData->setTitle($form->get('title')->getData());
            $imageGalleryProductData->setSubject($form->get('subject')->getData());
            $imageGalleryProductData->setAlt($form->get('alt')->getData());
            $imageGalleryProductData->setDisplayStatus($form->get('displayStatus')->getData());
            /////smallPic/////////////////////////
            if($form->get('file')->getData() != ""){
                $filePatch = $imageGalleryProductData->getFile();
                $fileUploader->deleteImageGallery($filePatch);
                $file = $form->get('file')->getData();
                $smallPic = $fileUploader->uploadImageGallery($file);
                $imageGalleryProductData->setFile($smallPic);
            }
            //delete cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listImagesGalleryProduct',array('id' => $imageGalleryProductData->getIdProduct()->getId()));
        }
        return $this->render('AdminPanel/ImagesGalleryProduct/edit_image_gallery_product.html.twig', array(
            'form' => $form->createView(),
            'imageGalleryProductData' => $imageGalleryProductData,
        ));
    }
    /**
     * @Route("/admin_Cp/ImagesGalleryProduct/deleteImagesGalleryProduct/{id}/{idProduct}",name="deleteImagesGalleryProduct")
     *
     */
    public function deleteImagesGalleryProduct($idProduct,Request $request, $id,FileUploader $fileUploader){
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
        return $this->redirectToRoute('listImagesGalleryProduct',array('id' => $idProduct));
    }
    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('imageGallery*××find−−×××3');

    }
}
