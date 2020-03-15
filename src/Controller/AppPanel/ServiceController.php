<?php
/**
 * Created by PhpStorm.
 * User: morteza
 * Date: 10/5/2019
 * Time: 1:16 AM
 */

namespace App\Controller\AppPanel;
use App\Entity\CategoryNews;
use App\Entity\Comment;
use App\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Utility\AppApi;
//use Symfony\Component\Cache\Adapter\RedisAdapter;

class ServiceController extends  AbstractController
{
    /**
     * @Route("/Service/{id}/{slug}",name="ServiceDetailAction")
     */
    public function DetailsService($id,Request $request){


        $ServiceData = $this->getDoctrine()->getManager()->getRepository('App:Service')->finById($id);

        $ImageGalleryData = $this->getDoctrine()->getManager()->getRepository('App:ImageGallery')->
        findByLimit("idService",$ServiceData[0]['id']);


        return $this->render("AppPanel/Service/details_service.html.twig",array(
            "ServiceData"       => $ServiceData[0],
            "ImageGalleries" => $ImageGalleryData,

        ));
    }

    /**
     * @Route("/ServiceList/",name="ServiceList")
     */
    public  function ServiceListAction (Request $request){

        return $this->render("AppPanel/Service/list_service.html.twig",array(

        ));
    }
    /**
     * @Route("/ListService/jsonFile",name="ServicejsonFile")
     */
    public function JsonListService(Request $request){
        $createArray = new AppApi();
        $Service = $this->getDoctrine()->getManager()->getRepository('App:Service')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($Service,"Service"));
    }
    /**
     * @Route("/mainService/",name="ServiceMain")
     */
    public  function CategoryArticleListAction (Request $request){

        return $this->render("AppPanel/Service/list_category_service.html.twig",array(

        ));
    }
    /**
     * @Route("/ListCategoryService/jsonFile",name="ServiceCategoryJsonFile")
     */
    public function JsonListCategoryService(Request $request){
        $createArray = new AppApi();
        $ServiceCategory = $this->getDoctrine()->getManager()->getRepository('App:CategoryService')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($ServiceCategory,'ServiceCategory'));
    }
    /**
     * @Route("/ServiceCategory/{id}/{slug}",name="ServiceCategoryDetails")
     */
    public function ServiceCategoryDetails($id){
        $ServiceCategory = $this->getDoctrine()->getManager()->getRepository('App:CategoryService')->find($id);
        return $this->render("AppPanel/Service/service_category_details_list.html.twig",array(
            "ServiceCategories" => $ServiceCategory,
        ));
    }
    /**
     * @Route("/ListDetailsCategoryService/jsonFile/{id}",name="ServiceDetailsCategoryJsonFile")
     */
    public function JsonListDetailsCategoryService($id,Request $request){
        $createArray = new AppApi();
        $Service = $this->getDoctrine()->getManager()->getRepository('App:Service')->findBy(["idCategory"=>$id],['id'=>"DESC"]);
        // var_dump($Articles);
        return $this->json($createArray->apiJson($Service,'Service'));
    }
}