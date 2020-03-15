<?php

namespace App\Controller\AdminPanel;
use App\Entity\Article;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\ArticleType;
use App\Form\Type\CommentType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\ImagesGallery;
use Doctrine\Common\Collections\ArrayCollection;

class ArticleController extends AbstractController
{


    /**
     * @Route("/admin_Cp/newArticle",name="newArticle")
     */
    public function newArticleAction(Request $request,FileUploader $fileUploader)
    {
        $Article = new Article();
        $form = $this->createForm(ArticleType::class,$Article ,array(
            'method' => 'POST',
            'action' => $this->generateUrl('newArticle'),
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
                'panelMainPageTopArticle' => null,
                ]
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ////////////smallPic///////////

            $file = $Article->getSmallPic();
            $smallPic = $fileUploader->uploadArticlePic($file);
            $Article->setSmallPic($smallPic);

            ////////////largePic///////////
            $file = $Article->getLargePic();
            $largePic = $fileUploader->uploadArticlePic($file);
            $Article->setLargePic($largePic);
            ///////////////////////////
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $em->persist($data);
            ///deleteCache Redis
            ///delete Cache redis
            $this->deleteCacheAfterChangeDataBase($em);
            
            $em->flush();


            $this->addFlash(
                'success',
                'مقالات  جدید اضافه شد.'
            );
            return $this->redirectToRoute('listArticle');

        }
        return $this->render('AdminPanel/Article/new_article.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin_Cp/Article/editArticle/{id}",name="editArticle")
     */
    public function editArticleAction(Request $request, $id,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $articleRepo=$em->getRepository('App:Article');
        $articleData = $articleRepo->find($id);
        // $satelliteImage=new satelliteImage;
        $Article = new Article();


        $form = $this->createForm(ArticleType::class,$Article,array(
            'action' => $this->generateUrl('editArticle',array('id' => $articleData->getId())),
            'attr' => array(
                'class' => 'dropzone',
                'id'  => "my-awesome-dropzone"
            ),
            'method' => 'POST',
            [
                'name'           => $articleData->getName(),
                'title'          => $articleData->getTitle(),
                'subject'        => $articleData->getSubject(),
                'description'    => $articleData->getDescription(),
                'descriptionSeo' => $articleData->getDescriptionSeo(),
                'smallPic'       => $articleData->getSmallPic(),
                'largePic'       => $articleData->getLargePic(),
                'idCategory'     => $articleData->getIdCategory(),
                'labelKeyWord'   => $articleData->getLabelKeyWord(),
                'urlSlug'        => $articleData->getUrlSlug(),
                'authorName'     => $articleData->getAuthorName(),
                'displayStatus'  => $articleData->getDisplayStatus(),
                'panelMainPageTopArticle'  => $articleData->getPanelMainPageTopArticle(),
                ]
        ));
        if ($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);

            $articleData->setName($form->get('name')->getData());
            $articleData->setTitle($form->get('title')->getData());
            $articleData->setSubject($form->get('subject')->getData());
            $articleData->setDescription($form->get('description')->getData());
            $articleData->setDescriptionSeo($form->get('descriptionSeo')->getData());
            $articleData->setDisplayStatus($form->get('displayStatus')->getData());
            $articleData->setIdCategory($form->get('idCategory')->getData());
            $articleData->setLabelKeyWord($form->get('labelKeyWord')->getData());
            $articleData->setUrlSlug($form->get('urlSlug')->getData());
            $articleData->setAuthorName($form->get('authorName')->getData());
            $articleData->setPanelMainPageTopArticle($form->get('panelMainPageTopArticle')->getData());
            $articleData->setLastUpdate(new \DateTime());

            /////smallPic/////////////////////////
            if($form->get('smallPic')->getData() != ""){
                $filePatch = $articleData->getSmallPic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('smallPic')->getData();
                $smallPic = $fileUploader->uploadArticlePic($file);
                $articleData->setSmallPic($smallPic);
            }
            ///////////////largePic///////
            if($form->get('largePic')->getData() != ""){
                $filePatch = $articleData->getLargePic();
                $fileUploader->deleteFileArticle($filePatch);
                $file = $form->get('largePic')->getData();
                $largePic = $fileUploader->uploadArticlePic($file);
                $articleData->setLargePic($largePic);
            }

            ///deleteCache Redis
            $this->deleteCacheAfterChangeDataBase($em);

            $em->flush();
            $this->addFlash(
                'success',
                'اطلاعات با موفقیت ویرایش شد'
            );
            return $this->redirectToRoute('listArticle');
        }
        return $this->render('AdminPanel/Article/edit_article.html.twig', array(
            'form' => $form->createView(),
            'Articles' => $articleData,
        ));
    }

    /**
     * @Route("/admin_Cp/listArticle",name="listArticle")
     */
    public function listArticleAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository(Article::class);
        $allArticleQuery = $articleRepository->createQueryBuilder('n')
            ->orderBy('n.dateInsert', 'DESC')
//            ->setParameter('status', 'canceled')
            ->getQuery();

        $article = $paginator->paginate(
            $allArticleQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/Article/list_article.html.twig', array(
            'Articles' => $article
        ));
    }

    /**
     * @Route("/admin_Cp/listMostViewNews",name="listMostViewArticle")
     */
    public function listMostViewNewsAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT n FROM App:News n ";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $request->query;
        $pagination = $paginator->paginate(
            $query, /* query NOT result */


            $request->query->getInt('page', 1)/*page number*/,
            10 ,/*limit per page*/
            array('defaultSortFieldName' => 'n.counterView', 'defaultSortDirection' => 'desc')
        );

        return $this->render('AdminPanel/News/list_MostViewNews.html.twig', array(
            'Newss' => $pagination
        ));
    }
    /**
     * @Route("/admin_Cp/Article/deleteArticle/{id}",name="deleteArticle")
     *
     */
    public function deleteAction(Request $request, $id,FileUploader $fileUploader){
        $em = $this->getDoctrine()->getManager();
        $categoryRe = $em->getRepository('App:Article');
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
        return $this->redirectToRoute('listArticle');
    }


    /**
     * @Route("/admin_Cp/listCommentArticle",name="listCommentArticle")
     */
    public function listCommentArticleAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository(Comment::class);
        $allArticleQuery = $articleRepository->createQueryBuilder('a')
            ->orderBy('a.dateInsert', 'DESC')
            ->Where('a.idArticle IS NOT NULL ')
            ->getQuery();

        $comments = $paginator->paginate(
            $allArticleQuery,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('AdminPanel/Article/list_article_comment.html.twig', array(
            'Comments' => $comments
        ));
    }
    /**
     * @Route("/admin_Cp/ArticleComment/editArticleComment/{id}",name="editArticleComment")
     */
    public function editArticleCommentAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentRepo=$em->getRepository('App:Comment');
        $commentData = $commentRepo->find($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment,array(
            'action' => $this->generateUrl('editArticleComment',array('id' => $commentData->getId())),
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
            return $this->redirectToRoute('listCommentArticle');
        }
        return $this->render('AdminPanel/Article/edit_comment_Article.html.twig', array(
            'form' => $form->createView(),
            'commentData' => $commentData
        ));
    }
    /**
     * @Route("/admin_Cp/article/deleteCommentArticle/{id}",name="deleteCommentArticle")
     *
     */
    public function deleteCommentArticleAction($id){
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
        return $this->redirectToRoute('listCommentArticle');
    }

    ////delete cache method
    private function deleteCacheAfterChangeDataBase($em){
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('Article××−−By××Id×××−1');
        $cacheDriver->delete('Article××−−By××Limit×××−2');
        $cacheDriver->delete('Article××−−By××Except×××id−3');
        $cacheDriver->delete('Article××−−By××Except×××id××××cat−3');
        $cacheDriver->delete('CategoryArticle×××−−×1');
    }
}
