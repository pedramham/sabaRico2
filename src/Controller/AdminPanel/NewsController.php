<?php

namespace App\Controller\AdminPanel;
use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\NewsType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Comment;
use App\Form\Type\CommentType;
class NewsController extends AbstractController
{


    /**
     * @Route("/admin_Cp/newNews",name="newNews")
     */
    public function newNewsAction(Request $request,FileUploader $fileUploader)
    {
        $News = new News();
        $form = $this->createForm(NewsType::class,$News ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newNews'),
            [
                'name'           => null,
                'title'          => null,
                'subject'        => null,
                'description'    => null,
                'descriptionSeo' => null,
                'smallPic'       => null,
                'largPic'        => null,
                'idCategory'     => null,
                'labelKeyWord'   => null,
                'urlSlug'        => null,
                'authorName'     => null,
                'displayStatus' => null,
                'panelNewsCategory' => null,
                ]
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////smallPic///////////
            $file = $News->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $News->setSmallPic($smallPic);

            ////////////largPic///////////
            $file = $News->getLargPic();
            $largPic = $fileUploader->uploadArticlePic($file);
            $News->setLargPic($largPic);
            ///////////////////////////
            $data = $form->getData();
            // var_dump($data);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $em->flush();
            $this->addFlash(
                'success',
                'اخبار جدید اضافه شد.'
            );
            return $this->redirectToRoute('listNews');
        }
        return $this->render('AdminPanel/News/new_news.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/News/editNews/{id}",name="editNews")
     */
    public function editNewsAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $newsRepo=$em->getRepository('App:News');
        $newsData = $newsRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $News = new News();
        $form = $this->createForm(NewsType::class,$News,array(
            'action' => $this->generateUrl('editNews',array('id' => $newsData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'        => $newsData->getName(),
                'title'       => $newsData->getTitle(),
                'subject'     => $newsData->getSubject(),
                'description' => $newsData->getDescription(),
                'descriptionSeo' => $newsData->getDescriptionSeo(),
                'smallPic'    => $newsData->getSmallPic(),
                'largPic'     => $newsData->getLargPic(),
                'idCategory'  => $newsData->getIdCategory(),
                'labelKeyWord'  => $newsData->getLabelKeyWord(),
                'urlSlug'       => $newsData->getUrlSlug(),
                'authorName'       => $newsData->getAuthorName(),
                'displayStatus' => $newsData->getDisplayStatus(),
                'panelNewsCategory' => $newsData->getPanelNewsCategory(),
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);
            $data = $form->getData();
            $newsData->setName($form->get('name')->getData());
            $newsData->setTitle($form->get('title')->getData());
            $newsData->setSubject($form->get('subject')->getData());
            $newsData->setDescription($form->get('description')->getData());
            $newsData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $newsData->setDisplayStatus($form->get('displayStatus')->getData());
            $newsData->setIdCategory($form->get('idCategory')->getData());
            $newsData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $newsData->setUrlSlug($form->get('urlSlug')->getData());
            $newsData->setAuthorName($form->get('authorName')->getData());
            $newsData->setPanelNewsCategory($form->get('panelNewsCategory')->getData());
            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $newsData->getSmallPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadArticlePic($file);
                $newsData->setSmallPic($smallPic);
            }
            ///////////////largePic///////
            if($form->get('largPic')->getData() != ""){
                $filePatch = $newsData->getLargPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('largPic')->getData();
                $largPic = $fileUploader->uploadArticlePic($file);
                $newsData->setLargPic($largPic);
            }

            $em->flush();
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listNews');
        }
        return $this->render('AdminPanel/News/edit_news.html.twig', array(
            'form' => $form->createView(),
            'Newss' => $newsData
        ));
    }

    /**
     * @Route("/admin_Cp/listNews",name="listNews")
     */
    public function listNewsAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $newsRepository = $em->getRepository(News::class);
        $allNewsQuery = $newsRepository->createQueryBuilder('n')
            ->orderBy('n.dateInsert', 'DESC')
//            ->setParameter('status', 'canceled')
            ->getQuery();

        $newses = $paginator->paginate(
            $allNewsQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/News/list_news.html.twig', array(
            'Newss' => $newses
        ));
    }
    /**
     * @Route("/admin_Cp/News/deleteNews/{id}",name="deleteNews")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:News');
        $category = $categoryRe->find($id);
        if(is_null($category)){
            throw $this->createNotFoundException("No News Found for id : ",$id);
        }
        $filePatch2 = $category->getLargPic();
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
        return $this->redirectToRoute('listNews');
    }

    /**
     * @Route("/admin_Cp/listCommentNews",name="listCommentNews")
     */
    public function listCommentNewsAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $newsRepository = $em->getRepository(Comment::class);
        $allNewsQuery = $newsRepository->createQueryBuilder('n')
            ->orderBy('n.dateInsert', 'DESC')
            ->Where('n.idNews IS NOT NULL ')
            ->getQuery();

        $comments = $paginator->paginate(
            $allNewsQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/News/list_news_comment.html.twig', array(
            'Comments' => $comments
        ));
    }

    /**
     * @Route("/admin_Cp/NewsComment/editNewsComment/{id}",name="editNewsComment")
     */
    public function editNewsCommentAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentRepo=$em->getRepository('App:Comment');
        $commentData = $commentRepo->find($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment,array(
            'action' => $this->generateUrl('editNewsComment',array('id' => $commentData->getId())),
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
            return $this->redirectToRoute('listCommentNews');
        }
        return $this->render('AdminPanel/News/edit_comment_news.html.twig', array(
            'form' => $form->createView(),
            'commentData' => $commentData
        ));
    }


    /**
     * @Route("/admin_Cp/news/deleteCommentNews/{id}",name="deleteCommentNews")
     *
     */
    public function deleteCommentNewsAction($id){
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
        return $this->redirectToRoute('listCommentNews');
    }

    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('News××−by−××id×1');
        $cacheDriver->delete('News××−by−××Limit××2');
        $cacheDriver->delete('News××−by−××relate×××3');
        $cacheDriver->delete('category××××news−×××−−×1');

    }
}
