<?php
/**
 * Created by PhpStorm.
 * User: morteza
 * Date: 10/5/2019
 * Time: 1:16 AM
 */

namespace App\Controller\AppPanel;
use App\Entity\CategoryNews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Utility\AppApi;

class NewsController extends  AbstractController
{
    /**
     * @Route("/News/{id}/{slug}",name="NewsDetailsIndex")
     */
    public function DetailsNews($id){
        $NewsData = $this->getDoctrine()->getManager()->getRepository('App:News')->finById($id);

        $ImageGalleryData = $this->getDoctrine()->getManager()->getRepository('App:ImageGallery')->
        findByLimit("idNews",$NewsData[0]['id']);
        return $this->render("AppPanel/News/details_news.html.twig",array(
            "News"           => $NewsData[0],
            "ImageGalleries" => $ImageGalleryData
        ));
    }
    /**
     * @Route("/ListNews/",name="NewsList")
     */
    public  function NewsListAction (Request $request){
        return $this->render("AppPanel/News/list_news.html.twig",array(

        ));
    }
    /**
     * @Route("/CatNews/{id}/{slug}",name="NewsCategoryDetails")
     */
    public function NewsCategoryDetails($id){
        $NewsCategory = $this->getDoctrine()->getManager()->getRepository('App:CategoryNews')->find($id);

        return $this->render("AppPanel/News/news_category_details_list.html.twig",array(
            "NewsCategory" => $NewsCategory,
        ));
    }
    /**
     * @Route("/NewsCM",name="CategoryNewsList")
     */
    public  function CategoryArticleListAction (Request $request){

        return $this->render("AppPanel/News/list_category_news.html.twig",array(

        ));
    }
    /**
     * @Route("/ListNews/jsonFile",name="NewsjsonFile")
     */
    public function JsonListNews(Request $request){
        $createArray = new AppApi();
        $News = $this->getDoctrine()->getManager()->getRepository('App:News')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($News,"News"));
    }
    /**
     * @Route("/ListDetailsCategoryNews/jsonFile/{id}",name="NewsDetailsCategoryJsonFile")
     */
    public function JsonListDetailsCategoryNews($id,Request $request){
        $createArray = new AppApi();
        $Newses = $this->getDoctrine()->getManager()->getRepository('App:News')->findBy(["idCategory"=>$id],['id'=>"DESC"]);
        // var_dump($Articles);
        return $this->json($createArray->apiJson($Newses,'News'));
    }
    /**
     * @Route("/ListCategoryNews/jsonFile",name="NewsCategoryJsonFile")
     */
    public function JsonListCategoryArticle(Request $request){
        $createArray = new AppApi();
        $News = $this->getDoctrine()->getManager()->getRepository('App:CategoryNews')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($News,'CatNews'));
    }
}