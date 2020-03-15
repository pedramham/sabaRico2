<?php

namespace App\Controller\AdminPanel;
use App\Entity\Service;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ServiceType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Type\CommentType;
class ServiceController extends AbstractController
{


    /**
     * @Route("/admin_Cp/newService",name="newService")
     */
    public function newServiceAction(Request $request,FileUploader $fileUploader)
    {
        $Service = new Service();
        $form = $this->createForm(ServiceType::class,$Service ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newService'),
            [
                'name'           => null,
                'title'          => null,
                'subject'        => null,
                'description'    => null,
                'descriptionSeo' => null,
                'smallPic'       => null,
                'largePic'       => null,
                'idCategory'     => null,
                'labelKeyWord'   => null,
                'urlSlug'        => null,
                'authorName'     => null,
                'displayStatus'  => null,
                'panelLastService'  => null,
                ]
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $Service->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $Service->setSmallPic($smallPic);

            ////////////largePic///////////
            $file = $Service->getLargePic();
            $largePic = $fileUploader->uploadArticlePic($file);
            $Service->setLargePic($largePic);
            ///////////////////////////
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->persist($data);
            $em->flush();
            $this->addFlash(
                'success',
                'خدمات  جدید اضافه شد.'
            );
            return $this->redirectToRoute('listService');

        }
        return $this->render('AdminPanel/Service/new_service.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/Service/editService/{id}",name="editService")
     */
    public function editArticleAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $serviceRepo=$em->getRepository('App:Service');
        $serviceData = $serviceRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $Service = new Service();
        $form = $this->createForm(ServiceType::class,$Service,array(
            'action' => $this->generateUrl('editService',array('id' => $serviceData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'           => $serviceData->getName(),
                'title'          => $serviceData->getTitle(),
                'subject'        => $serviceData->getSubject(),
                'description'    => $serviceData->getDescription(),
                'descriptionSeo' => $serviceData->getDescriptionSeo(),
                'smallPic'       => $serviceData->getSmallPic(),
                'largePic'       => $serviceData->getLargePic(),
                'idCategory'     => $serviceData->getIdCategory(),
                'labelKeyWord'   => $serviceData->getLabelKeyWord(),
                'urlSlug'        => $serviceData->getUrlSlug(),
                'authorName'     => $serviceData->getAuthorName(),
                'displayStatus'  => $serviceData->getDisplayStatus(),
                'panelLastService'  => $serviceData->getPanelLastService(),
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);
            $data = $form->getData();
            $serviceData->setName($form->get('name')->getData());
            $serviceData->setTitle($form->get('title')->getData());
            $serviceData->setSubject($form->get('subject')->getData());
            $serviceData->setDescription($form->get('description')->getData());
            $serviceData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $serviceData->setDisplayStatus($form->get('displayStatus')->getData());
            $serviceData->setIdCategory($form->get('idCategory')->getData());
            $serviceData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $serviceData->setUrlSlug($form->get('urlSlug')->getData());
            $serviceData->setAuthorName($form->get('authorName')->getData());
            $serviceData->setPanelLastService($form->get('panelLastService')->getData());
            $serviceData->setLastUpdate(new \DateTime());
            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $serviceData->getSmallPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadArticlePic($file);
                $serviceData->setSmallPic($smallPic);
            }
            ///////////////largePic///////
            if($form->get('largePic')->getData() != ""){
                $filePatch = $serviceData->getLargePic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('largePic')->getData();
                $largePic = $fileUploader->uploadArticlePic($file);
                $serviceData->setLargePic($largePic);
            }
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listService');
        }
        return $this->render('AdminPanel/Service/edit_service.html.twig', array(
            'form' => $form->createView(),
            'Service' => $serviceData
        ));
    }

    /**
     * @Route("/admin_Cp/listService",name="listService")
     */
    public function listServiceAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $serviceRepository = $em->getRepository(Service::class);
        $allServiceQuery = $serviceRepository->createQueryBuilder('n')
            ->orderBy('n.dateInsert', 'DESC')
//            ->setParameter('status', 'canceled')
            ->getQuery();

        $service = $paginator->paginate(
            $allServiceQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/Service/list_service.html.twig', array(
            'Services' => $service
        ));
    }

    /**
     * @Route("/admin_Cp/Service/deleteService/{id}",name="deleteService")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:Service');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No News Found for id : ",$id);
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
        return $this->redirectToRoute('listService');
    }

    /**
     * @Route("/admin_Cp/listCommentSevivce",name="listCommentService")
     */
    public function listCommentServiceAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $serviceRepository = $em->getRepository(Comment::class);
        $allServiceQuery = $serviceRepository->createQueryBuilder('s')
            ->orderBy('s.dateInsert', 'DESC')
            ->Where('s.idService IS NOT NULL ')
            ->getQuery();

        $comments = $paginator->paginate(
            $allServiceQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/Service/list_service_comment.html.twig', array(
            'Comments' => $comments
        ));
    }

    /**
     * @Route("/admin_Cp/ServiceComment/editServiceComment/{id}",name="editServiceComment")
     */
    public function editServiceCommentAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentRepo=$em->getRepository('App:Comment');
        $commentData = $commentRepo->find($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment,array(
            'action' => $this->generateUrl('editServiceComment',array('id' => $commentData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'          => $commentData->getName(),
                'email'         => $commentData->getEmail(),
                'subject'       => $commentData->getSubject(),
                'nameAdmin'     => $commentData->getNameAdmin(),
                'answerAdmin'   => $commentData->getAnswerAdmin(),
                'displayStatus' => $commentData->getDisplayStatus(),
            ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){
            $form->handleRequest($request);
            $commentData->setName($form->get('name')->getData());
            $commentData->setEmail($form->get('email')->getData());
            $commentData->setSubject($form->get('subject')->getData());
            $commentData->setDisplayStatus($form->get('displayStatus')->getData());
            $commentData->setAnswerAdmin($form->get('answerAdmin')->getData());
            $commentData->setNameAdmin($form->get('nameAdmin')->getData());
            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listCommentService');
        }
        return $this->render('AdminPanel/Service/edit_comment_service.html.twig', array(
            'form' => $form->createView(),
            'commentData' => $commentData
        ));
    }


    /**
     * @Route("/admin_Cp/service/deleteCommentService/{id}",name="deleteCommentService")
     *
     */
    public function deleteCommentServiceAction($id){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:Comment');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No Comment Found for id : ",$id);
        }$em->remove($category);
        $em->flush();
        $this->addFlash(
            'success',
            'اطلاعات با وفقیت حذف شد'
        );
        return $this->redirectToRoute('listCommentService');
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
