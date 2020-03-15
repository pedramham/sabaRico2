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
use App\Controller\Utility\ApiProduct;
//use Symfony\Component\Cache\Adapter\RedisAdapter;

class ProductController extends  AbstractController
{
    /**
     * @Route("/Product/{id}/{slug}",name="ProductDetails")
     */
    public function DetailsProduct($id,Request $request){

       // $ProductData = $this->getDoctrine()->getManager()->getRepository('App:Product')->find($id);
        $ProductData = $this->getDoctrine()->getManager()->getRepository('App:Product')->
        finById($id);

        $ImageGalleryData = $this->getDoctrine()->getManager()->getRepository('App:ImageGallery')->
        findByLimit("idProduct",$ProductData[0]['id']);


        return $this->render("AppPanel/Product/details_product.html.twig",array(
            "ProductData"      => $ProductData[0],
            "ImageGalleries" => $ImageGalleryData

        ));
    }

    /**
     * @Route("/ListProduct",name="ProductList")
     */
    public  function ProductListAction (Request $request){
        return $this->render("AppPanel/Product/list_product.html.twig",array());
    }
    /**
     * @Route("/ListProduct/jsonFile",name="ProductjsonFile")
     */
    public function JsonListArticle(Request $request){
        $createArray = new ApiProduct();
        $Products = $this->getDoctrine()->getManager()->getRepository('App:Product')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($Products,'Product'));
    }

    /**
     * @Route("/CatProduct/{id}/{slug}",name="ProductCategoryDetails")
     */
    public function ProductCategoryDetails($id){
        $ProCategory = $this->getDoctrine()->getManager()->getRepository('App:CategoryProduct')->find($id);
        return $this->render("AppPanel/Product/product_category_details_list.html.twig",array(
           "ProCategory" => $ProCategory
        ));
    }
    /**
     * @Route("/ListDetailsCategoryProduct/jsonFile/{id}",name="ProductDetailsCategoryJsonFile")
     */
    public function JsonListDetailsCategoryProduct($id,Request $request){
        $createArray = new ApiProduct();
        $Product = $this->getDoctrine()->getManager()->getRepository('App:Product')->findBy(["idCategoryProduct"=>$id],['id'=>"DESC"]);
        return $this->json($createArray->apiJson($Product));
    }
}