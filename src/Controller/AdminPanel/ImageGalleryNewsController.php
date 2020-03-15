<?php

namespace App\Controller\AdminPanel;
use App\Entity\News;
use App\Entity\ImageGallery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ImageGalleryType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;

class ImageGalleryNewsController extends AbstractController
{
    /**
     * @Route("/admin_Cp/newImageGalleyNews/{id}",name="newImageGalleyNews")
     */
    public function newImageGalleyNewsAction($id,Request $request,FileUploader $fileUploader)
    {
        $ImageGalleryNews = new ImageGallery();
        $form = $this->createForm(ImageGalleryType::class,$ImageGalleryNews ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newImageGalleyNews',array('id' => $id)),
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
            $file = $ImageGalleryNews->getFile();
            $file = $fileUploader->uploadImageGallery($file);
            $ImageGalleryNews->setFile($file);
            $News = $this->getDoctrine()->getManager()->getRepository('App:News')->find($id);
            $ImageGalleryNews->setIdNews($News);
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
            return $this->redirectToRoute('listImagesGalleryNews',array('id' => $id));
        }
        return $this->render('AdminPanel/ImagesGalleryNews/new_image_gallery_news.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/admin_Cp/listNewsImagesGallery",name="listNewsImagesGallery")
     */
    public function listNewsImagesGalleryAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleyNewsRepository = $em->getRepository(News::class);
        $allNewsQuery = $imageGalleyNewsRepository->createQueryBuilder('i')
            ->orderBy('i.dateInsert', 'DESC')
            ->getQuery();

        $News = $paginator->paginate(
            $allNewsQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGalleryNews/list_news_image_gallery.html.twig', array(
            'Newses' => $News
        ));
    }
    /**
     * @Route("/admin_Cp/listImagesGalleryNews/{id}",name="listImagesGalleryNews")
     */
    public function listImagesGalleryNewsAction($id,Request $request,PaginatorInterface $paginator)
    {
        $imageGalleyNewsRepository = $this->getDoctrine()->getManager()->getRepository(ImageGallery::class);
        if ($id == 0){
            $allNewsQuery = $imageGalleyNewsRepository->createQueryBuilder('i')
                ->orderBy('i.dateInsert', 'DESC')
                ->getQuery();
        }else{
            $allNewsQuery = $imageGalleyNewsRepository->createQueryBuilder('i')
                ->where("i.idNews = :idNews")
                ->orderBy('i.dateInsert', 'DESC')
                ->setParameter('idNews', $id)
                ->getQuery();
        }

        $newsImage = $paginator->paginate(
            $allNewsQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/ImagesGalleryNews/list_image_gallery_news.html.twig', array(
            'NewsImages' => $newsImage,
            "idNewsEmpty" => $id,
        ));
    }

    /**
     * @Route("/admin_Cp/ImagesGalleryNews/editImagesGalleryNews/{id}",name="editImagesGalleryNews")
     */
    public function editImagesGalleryNewsAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $imageGalleryNewsRepo=$em->getRepository('App:ImageGallery');
        $imageGalleryNewsData = $imageGalleryNewsRepo->find($id);
        $ImageGalleryNews = new ImageGallery();

        $form = $this->createForm(ImageGalleryType::class,$ImageGalleryNews,array(
            'action' => $this->generateUrl('editImagesGalleryNews',array('id' => $imageGalleryNewsData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'           => $imageGalleryNewsData->getName(),
                'title'          => $imageGalleryNewsData->getTitle(),
                'subject'        => $imageGalleryNewsData->getSubject(),
                'file'           => $imageGalleryNewsData->getFile(),
                'alt'            => $imageGalleryNewsData->getAlt(),
                'displayStatus'  => $imageGalleryNewsData->getDisplayStatus(),
                'displayPriority'=> $imageGalleryNewsData->getDisplayPriority()
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);

            $imageGalleryNewsData->setName($form->get('name')->getData());
            $imageGalleryNewsData->setTitle($form->get('title')->getData());
            $imageGalleryNewsData->setSubject($form->get('subject')->getData());
            $imageGalleryNewsData->setAlt($form->get('alt')->getData());
            $imageGalleryNewsData->setDisplayStatus($form->get('displayStatus')->getData());
            /////smallPic/////////////////////////
            if($form->get('file')->getData() != ""){
                $filePatch = $imageGalleryNewsData->getFile();
                $fileUploader->deleteImageGallery($filePatch);
                $file = $form->get('file')->getData();
                $smallPic = $fileUploader->uploadImageGallery($file);
                $imageGalleryNewsData->setFile($smallPic);
            }
            //delete cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listImagesGalleryNews',array('id' => $imageGalleryNewsData->getIdNews()->getId()));
        }
        return $this->render('AdminPanel/ImagesGalleryNews/edit_image_gallery_news.html.twig', array(
            'form' => $form->createView(),
            'imageGalleryNewsData' => $imageGalleryNewsData,
        ));
    }
    /**
     * @Route("/admin_Cp/ImagesGalleryNews/deleteImagesGalleryNews/{id}/{idNews}",name="deleteImagesGalleryNews")
     *
     */
    public function deleteImagesGallery($idNews,Request $request, $id,FileUploader $fileUploader){
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
        return $this->redirectToRoute('listImagesGalleryNews',array('id' => $idNews));
    }
    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('imageGallery*××find−−×××3');

    }
}
