<?php
namespace App\Controller\AppPanel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
class MainPageController extends  AbstractController
{
    /**
     * @Route("/", name="mainPageIndex")
     */
    public  function mainPageIndex(){

        return $this->render("AppPanel/MainPage/main_page.html.twig",array(
        ));
    }
    /**
     * @Route("/aboutUs", name="aboutUS")
     */
    public  function aboutUS(){

        return $this->render("AppPanel/MainPage/about_us.html.twig",array(
        ));
    }
    /**
     * @Route("/sitemap.xml", name="sitemap")
     */
    public function sitemapAction()
    {
        ///Article/////
        $repositoryArticle = $this->getDoctrine()
            ->getRepository('App:Article');
        $queryArticle=   $repositoryArticle->createQueryBuilder('a')
            ->select('a.id','a.title','a.name','a.urlSlug','a.dateInsert')
            ->Where('a.displayStatus = :displayStatus')
            ->setParameter('displayStatus',1)
            ->getQuery();
        $Article = $queryArticle->getResult();
        ///Article/////
        //news/////////////////////
        $repositoryNews = $this->getDoctrine()
            ->getRepository('App:News');
        $queryNews=   $repositoryNews->createQueryBuilder('n')
            ->select('n.id','n.title','n.dateInsert','n.urlSlug','n.dateInsert')
            ->Where('n.displayStatus = :displayStatus')
            ->setParameter('displayStatus',1)
            ->getQuery();
        $News = $queryNews->getResult();
//////////////////news///////////////
        //news/////////////////////
        $repositoryNews = $this->getDoctrine()
            ->getRepository('App:CategoryNews');
        $queryNews=   $repositoryNews->createQueryBuilder('c')
            ->select('c.id','c.title','c.dateInsert','c.urlSlug')
            ->Where('c.displayStatus = :displayStatus')
            ->setParameter('displayStatus',1)
            ->getQuery();
        $CategoryNews= $queryNews->getResult();
//////////////////news///////////////
/// //////////////////CategoryArticle///////////////
        $repositoryCategoryArticle = $this->getDoctrine()
            ->getRepository('App:CategoryArticle');
        $queryCategoryArticle=   $repositoryCategoryArticle->createQueryBuilder('c')
            ->select('c.id','c.title','c.dateInsert','c.urlSlug')
            ->Where('c.displayStatus = :displayStatus')
            ->setParameter('displayStatus',1)
            ->getQuery();
        $CategoryArticle= $queryCategoryArticle->getResult();
//////////////////CategoryArticle///////////////
        /// //////////////////CategoryServices///////////////
        $repositoryCategoryServices = $this->getDoctrine()
            ->getRepository('App:CategoryService');
        $queryCategoryServices=   $repositoryCategoryServices->createQueryBuilder('c')
            ->select('c.id','c.title','c.dateInsert','c.urlSlug')
            ->Where('c.displayStatus = :displayStatus')
            ->setParameter('displayStatus',1)
            ->getQuery();
        $CategoryServices= $queryCategoryServices->getResult();
//////////////////CategoryServices///////////////
        /// //////////////////Service///////////////
        $repositoryService = $this->getDoctrine()
            ->getRepository('App:Service');
        $queryService=   $repositoryService->createQueryBuilder('c')
            ->select('c.id','c.title','c.dateInsert','c.urlSlug')
            ->Where('c.displayStatus = :displayStatus')
            ->setParameter('displayStatus',1)
            ->getQuery();
        $Service= $queryService->getResult();
//////////////////CategoryServices///////////////
        /// //////////////////Content///////////////
        $repositoryContent = $this->getDoctrine()
            ->getRepository('App:Content');
        $queryContent=   $repositoryContent->createQueryBuilder('c')
            ->select('c.id','c.title','c.dateInsert','c.urlSlug')
            ->Where('c.displayStatus = :displayStatus')
            ->setParameter('displayStatus',1)
            ->getQuery();
        $Content= $queryContent->getResult();

        $url =$_SERVER['SERVER_NAME'];
        $http =isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
        $url = $http."://".$url;


        return $this->render('AppPanel/MainPage/sitemap.html.twig',[
                'ArticleData' => $Article,
                'Newss' =>$News,
                'CategoryNewses' =>$CategoryNews,
                'CategoryArticles' =>$CategoryArticle,
                'CategoryServices' =>$CategoryServices,
                'Service'          => $Service,
                'Contents'          => $Content,
                'url' => $url
            ]
        );
    }

}