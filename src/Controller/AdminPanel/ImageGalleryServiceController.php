<?php

namespace App\Controller\AdminPanel;
use App\Entity\Service;
use App\Entity\ImageGallery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ImageGalleryType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;

class ImageGalleryServiceController extends AbstractController
{
    /**
     * @Route("/admin_Cp/newImageGalleyService/{id}",name="newImageGalleyService")
     */
    public function newImageGalleyServiceAction($id,Request $request,FileUploader $fileUploader)
    {
        $ImageGalleryService = new ImageGallery();
        $form = $this->createForm(ImageGalleryType::class,$ImageGalleryService ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newImageGalleyService',array('id' => $id)),
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
            $file = $ImageGalleryService->getFile();
            $file = $fileUploader->uploadImageGallery($file);
            $ImageGalleryService->setFile($file);
            $Service = $this->getDoctrine()->getManager()->getRepository('App:Service')->find($id);
            $ImageGalleryService->setIdService($Service);
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
            return $this->redirectToRoute('listImagesGalleryService',array('id' => $id));
        }
        return $this->render('AdminPanel/ImagesGalleryService/new_image_gallery_service.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/admin_Cp/listServiceImagesGallery",name="listServiceImagesGallery")
     */
    public function listServiceImagesGalleryAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleyServiceRepository = $em->getRepository(Service::class);
        $allServiceQuery = $imageGalleyServiceRepository->createQueryBuilder('i')
            ->orderBy('i.dateInsert', 'DESC')
            ->getQuery();

        $Service = $paginator->paginate(
            $allServiceQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGalleryService/list_service_image_gallery.html.twig', array(
            'Services' => $Service
        ));
    }
    /**
     * @Route("/admin_Cp/listImagesGalleryService/{id}",name="listImagesGalleryService")
     */
    public function listImagesGalleryServiceAction($id,Request $request,PaginatorInterface $paginator)
    {
        $imageGalleyServiceRepository = $this->getDoctrine()->getManager()->getRepository(ImageGallery::class);
        if ($id == 0){
            $allServiceQuery = $imageGalleyServiceRepository->createQueryBuilder('i')
                ->orderBy('i.dateInsert', 'DESC')
                ->getQuery();
        }else{
            $allServiceQuery = $imageGalleyServiceRepository->createQueryBuilder('i')
                ->where("i.idService = :idService")
                ->orderBy('i.dateInsert', 'DESC')
                ->setParameter('idService', $id)
                ->getQuery();
        }

        $serviceImage = $paginator->paginate(
            $allServiceQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGalleryService/list_image_gallery_service.html.twig', array(
            'ServiceImages' => $serviceImage,
            "idServiceEmpty" => $id,
        ));
    }

    /**
     * @Route("/admin_Cp/ImagesGalleryService/editImagesGalleryService/{id}",name="editImagesGalleryService")
     */
    public function editImagesGalleryServiceAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleryServiceRepo=$em->getRepository('App:ImageGallery');
        $imageGalleryServiceData = $imageGalleryServiceRepo->find($id);
        $ImageGalleryService = new ImageGallery();

        $form = $this->createForm(ImageGalleryType::class,$ImageGalleryService,array(
            'action' => $this->generateUrl('editImagesGalleryService',array('id' => $imageGalleryServiceData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'           => $imageGalleryServiceData->getName(),
                'title'          => $imageGalleryServiceData->getTitle(),
                'subject'        => $imageGalleryServiceData->getSubject(),
                'file'           => $imageGalleryServiceData->getFile(),
                'alt'            => $imageGalleryServiceData->getAlt(),
                'displayStatus'  => $imageGalleryServiceData->getDisplayStatus(),
                'displayPriority'=> $imageGalleryServiceData->getDisplayPriority(),
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);

            $imageGalleryServiceData->setName($form->get('name')->getData());
            $imageGalleryServiceData->setTitle($form->get('title')->getData());
            $imageGalleryServiceData->setSubject($form->get('subject')->getData());
            $imageGalleryServiceData->setAlt($form->get('alt')->getData());
            $imageGalleryServiceData->setDisplayStatus($form->get('displayStatus')->getData());
            /////smallPic/////////////////////////
            if($form->get('file')->getData() != ""){
                $filePatch = $imageGalleryServiceData->getFile();
                $fileUploader->deleteImageGallery($filePatch);
                $file = $form->get('file')->getData();
                $file = $fileUploader->uploadImageGallery($file);
                $imageGalleryServiceData->setFile($file);
            }
            //delete cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listImagesGalleryService',array('id' => $imageGalleryServiceData->getIdService()->getId()));
        }
        return $this->render('AdminPanel/ImagesGalleryService/edit_image_gallery_service.html.twig', array(
            'form' => $form->createView(),
            'imageGalleryServiceData' => $imageGalleryServiceData,
        ));
    }
    /**
     * @Route("/admin_Cp/ImagesGalleryService/deleteImagesGalleryService/{id}/{idService}",name="deleteImagesGalleryService")
     *
     */
    public function deleteImagesGallery($idService,Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:ImageGallery');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No Service Found for id : ",$id);
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
        return $this->redirectToRoute('listImagesGalleryService',array('id' => $idService));
    }
    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('imageGallery*××find−−×××3');

    }
}
