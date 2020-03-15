<?php

namespace App\Controller\AdminPanel;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\VideoType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;

class VideoController extends AbstractController
{
    /**
     * @Route("/admin_Cp/newVideo",name="newVideo")
     */
    public function newVideoAction(Request $request,FileUploader $fileUploader)
    {
        $Video = new Video();
        $form = $this->createForm(VideoType::class,$Video ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newVideo'),
            [
                'name'           => null,
                'title'          => null,
                'subject'        => null,
                'description'    => null,
                'descriptionSeo' => null,
                'smallPic'       => null,
                'videoLink'      => null,
                'duringVideo'    => null,
                'idCategory'     => null,
                'labelKeyWord'   => null,
                'urlSlug'        => null,
                'authorName'     => null,
                'displayStatus' => null]
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $Video->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $Video->setSmallPic($smallPic);

            $data = $form->getData();
            // var_dump($data);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->addFlash(
                'success',
                'اخبار جدید اضافه شد.'
            );
            return $this->redirectToRoute('listVideo');
        }
        return $this->render('AdminPanel/Video/new_video.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/listVideo",name="listVideo")
     */
    public function listVideoAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $videoRepository = $em->getRepository(Video::class);
        $allVideoQuery = $videoRepository->createQueryBuilder('n')
            ->orderBy('n.dateInsert', 'DESC')
            ->getQuery();

        $videos = $paginator->paginate(
            $allVideoQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/Video/list_video.html.twig', array(
            'videos' => $videos
        ));
    }


    /**
     * @Route("/admin_Cp/Video/editVideo/{id}",name="editVideo")
     */
    public function editVideoAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $videoRepo=$em->getRepository('App:Video');
        $videoData = $videoRepo->find($id);

        $Video = new Video();
        $form = $this->createForm(VideoType::class,$Video,array(
            'action' => $this->generateUrl('editVideo',array('id' => $videoData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'        => $videoData->getName(),
                'title'       => $videoData->getTitle(),
                'subject'     => $videoData->getSubject(),
                'description' => $videoData->getDescription(),
                'descriptionSeo' => $videoData->getDescriptionSeo(),
                'smallPic'       => $videoData->getSmallPic(),
                'videoLink'      => $videoData->getVideoLink(),
                'duringVideo'    => $videoData->getDuringVideo(),
                'idCategory'     => $videoData->getIdCategory(),
                'labelKeyWord'   => $videoData->getLabelKeyWord(),
                'urlSlug'        => $videoData->getUrlSlug(),
                'authorName'     => $videoData->getAuthorName(),
                'displayStatus'  => $videoData->getDisplayStatus()]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);
            $data = $form->getData();
            $videoData->setName($form->get('name')->getData());
            $videoData->setTitle($form->get('title')->getData());
            $videoData->setSubject($form->get('subject')->getData());
            $videoData->setDescription($form->get('description')->getData());
            $videoData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $videoData->setDisplayStatus($form->get('displayStatus')->getData());
            $videoData->setIdCategory($form->get('idCategory')->getData());
            $videoData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $videoData->setUrlSlug($form->get('urlSlug')->getData());
            $videoData->setAuthorName($form->get('authorName')->getData());
            $videoData->setVideoLink($form->get('videoLink')->getData());
            $videoData->setDuringVideo($form->get('duringVideo')->getData());
            $videoData->setLastUpdate(new \DateTime());
            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $videoData->getSmallPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadArticlePic($file);
                $videoData->setSmallPic($smallPic);
            }

            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listVideo');
        }
        return $this->render('AdminPanel/Video/edit_video.html.twig', array(
            'form' => $form->createView(),
            'Newss' => $videoData
        ));
    }
    /**
     * @Route("/admin_Cp/Video/deleteVideo/{id}",name="deleteVideo")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:Video');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No News Found for id : ",$id);
        }

        $filePatch = $category->getSmallPic();
        $fileUploader->deleteFileArticle($filePatch);
        $em->remove($category);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listVideo');
    }


}
