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

class ContentController extends  AbstractController
{
    /**
     * @Route("/Content/{id}/{slug}",name="ContentDetails")
     */
    public function DetailsContent($id,Request $request){
        $ContentData = $this->getDoctrine()->getManager()->getRepository('App:Content')->find($id);
        return $this->render("AppPanel/Content/details_content.html.twig",array(
            "ContentData" => $ContentData,
        ));
    }

    /**
     * @Route("/ListContent",name="ContentList")
     */
    public  function ContentListAction (Request $request){

        return $this->render("AppPanel/Content/list_content.html.twig",array());
    }

    /**
     * @Route("/ListContent/jsonFile",name="ContentjsonFile")
     */
    public function JsonListArticle(Request $request){
        $createArray = new AppApi();
        $Contents = $this->getDoctrine()->getManager()->getRepository('App:Content')->findBy( [],array('id' => 'DESC'));
        return $this->json($createArray->apiJson($Contents,'Content'));
    }


}