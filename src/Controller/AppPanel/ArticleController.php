<?php
/**
 * Created by PhpStorm.
 * User: morteza
 * Date: 10/5/2019
 * Time: 1:16 AM
 */

namespace App\Controller\AppPanel;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utility\AppApi;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use App\Service\CacheRedis;
class ArticleController extends  AbstractController
{
    /**
     * @Route("/Article/{id}/{slug}",name="ArticleDetails")
     */
    public function DetailsArticle($id,Request $request){

        $ArticleData = $this->getDoctrine()->getManager()->getRepository(Article::class)->finById($id);
        $ImageGalleryData = $this->getDoctrine()->getManager()->getRepository('App:ImageGallery')->
        findByLimit("idArticle",$ArticleData[0]['id']);
//
     //   $redis = RedisAdapter::createConnection('redis://localhost:6379');
//        $redis->getKeys("/")
       // echo "Connection to server sucessfully";
//        $cacheRedis = CacheRedis::class;
//        var_dump($cacheRedis->get());
//        die();
//        $redis = new \Redis();
//        $redis->connect('127.0.0.1', 6379);

        //var_dump($ImageGalleryData);
//        echo phpinfo();
//        die();
//        $redis->hSet("taxi_car","dd",[$ImageGalleryData]);
//        $redis->hSet("taxi_car","model","yaris");
//        $redis->hSet("taxi_car","nr_starts",0);
//        $redis->hSet("taxi_car","license number","RO-PHP");
//        echo "license number :".$redis->hGet("taxi_car","license number")."<br>";
//        $redis->hDel("taxi_car","license number");
//        $taxi_car = $redis->hGetAll("taxi_car");
//        var_dump($taxi_car);
//       $list = "php frameworks list";
//        $redis->rPush($list,"symfony 1");
//        $redis->rPush($list,"symfony 4");
//        $redis->rPop($list);
//        echo "number of frameworks in list".$redis->lLen($list).'<br>';
//        $arlist = $redis->lRange($list,0,-1);
//        var_dump($arlist);
        //$redis->set("expire in 1hour","i have data for an hour");
      //  $redis->expire("expire in 1 hour",10);
//        $ttl = $redis->ttl("expire in hour");
//        var_dump($ttl);

        //store data in redis list
//        $redis->lpush("tutorial-list", "ss");
//        $redis->lpush("tutorial-list", "Mongodb");
//        $redis->lpush("tutorial-list", "Mysql");

       // die();

        return $this->render("AppPanel/Article/details_article.html.twig",array(
            "ArticleData"       => $ArticleData[0],
            "ImageGalleries" => $ImageGalleryData,

        ));
    }
    /**
     * @Route("/CatArticle/{id}/{slug}",name="ArticleCategoryDetails")
     */
    public function ArticleCategoryDetails($id){
        $ArticleCategory = $this->getDoctrine()->getManager()->getRepository('App:CategoryArticle')->find($id);

        return $this->render("AppPanel/Article/article_category_details_list.html.twig",array(
            "ArticleCategory" => $ArticleCategory,
        ));
    }
    /**
     * @Route("/ListArticle",name="ArticleList")
     */
    public  function ArticleListAction (Request $request){

//        var_dump($request->server->get('HTTP_HOST'));
//        $request->server->get('HTTP_HOST');
//        die();

        return $this->render("AppPanel/Article/list_article.html.twig",array(

        ));
    }
    /**
     * @Route("/ArticleCM",name="CategoryArticleList")
     */
    public  function CategoryArticleListAction (Request $request){

        return $this->render("AppPanel/Article/list_category_article.html.twig",array(

        ));
    }
    /**
     * @Route("/ListArticle/jsonFile",name="ArticlejsonFile")
     */
    public function JsonListArticle(Request $request){
        $createArray = new AppApi();
        $Articles = $this->getDoctrine()->getManager()->getRepository('App:Article')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($Articles,'Article'));
    }
    /**
     * @Route("/ListDetailsCategoryArticle/jsonFile/{id}",name="ArticleDetailsCategoryJsonFile")
     */
    public function JsonListDetailsCategoryArticle($id,Request $request){
        $createArray = new AppApi();
        $Articles = $this->getDoctrine()->getManager()->getRepository('App:Article')->findBy(["idCategory"=>$id],['id'=>"DESC"]);
       // var_dump($Articles);
        return $this->json($createArray->apiJson($Articles,'Article'));
    }
    /**
     * @Route("/ListCategoryArticle/jsonFile",name="ArticleCategoryJsonFile")
     */
    public function JsonListCategoryArticle(Request $request){
        $createArray = new AppApi();
        $Articles = $this->getDoctrine()->getManager()->getRepository('App:CategoryArticle')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($Articles,'CatArticle'));
    }
}