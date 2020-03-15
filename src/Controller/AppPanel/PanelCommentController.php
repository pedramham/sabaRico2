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
use Symfony\Component\HttpFoundation\Session\Session;

class PanelCommentController extends  AbstractController
{
    private $domain_url;
    public function __construct()
    {
        $this->domain_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    }

    /**
     * @Route("/Panel/Comment/{id}/{type}",name="CommentPanel")
     */
    public function CommentPanel($id,$type,Request $request){
        return $this->render("AppPanel/Includes/Comment/panel_comment.html.twig",array(
            "id"   => $id,
            "type" =>$type,
            'comments' =>  $this->fetchComment($type,$id),
        ));
    }
    /**
     * @Route("/submitComment/",name="submitComment")
     */
    public function submitComment(Request $request)
    {

        header("Content-type: application/json");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Origin: *.ampproject.org");
        header("AMP-Access-Control-Allow-Source-Origin: ".$this->domain_url);

            if ((isset( $_POST['name'])) and (isset($_POST['email'])) and (isset( $_POST['subject'])) and (isset($_POST['id']))) {
                $redirect_url = $this->getRedirectUrl($_POST['id'],$_POST['type']);
                $em = $this->getDoctrine()->getManager();
                $em->persist( $this->getIdCategory($_POST['id'],$_POST['type']));
                $em->flush();
                header("AMP-Redirect-To: ".$redirect_url);
                header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");
                return $this->json(array('name' => $_POST['name']));
            }
            else{
                header("HTTP/1.0 412 Precondition Failed", true, 412);
                return $this->json(array('error' => "خطایی پیش آمده دوباره تلاش کنید"));
                die();
            }
        }


        private function fetchComment($type,$id)
        {
            if($type=="articleBase") {
                return $this->getDoctrine()->getManager()->getRepository('App:Comment')->findByIdCategory($id,'idArticle');
            }
            if($type=="newsBase") {
                return $this->getDoctrine()->getManager()->getRepository('App:Comment')->findByIdCategory($id,'idNews');

            }
            if($type=="serviceBase"){
                return $this->getDoctrine()->getManager()->getRepository('App:Comment')->findByIdCategory($id,'idService');

            }
        }


        private function getRedirectUrl($id,$type){
            if($type=="articleBase"){
                return  $redirect_url =  $this->domain_url. $this->generateUrl('ArticleDetails', array('id' => $id,'slug'=>'Article'));
            }
            if($type=="newsBase"){
                return  $redirect_url =  $this->domain_url. $this->generateUrl('NewsDetailsIndex', array('id' => $id,'slug'=>'News'));
            }
            if($type=="serviceBase"){
                return  $redirect_url =  $this->domain_url. $this->generateUrl('ServiceDetailAction', array('id' => $id,'slug'=>'Service'));
            }

        }


        private function getIdCategory($id,$type){
            $comment = new Comment();
            if($type=="articleBase"){
                $Data = $this->getDoctrine()->getManager()->getRepository('App:Article')->find($id);
                $comment->setIdArticle($Data);
            }
            if ($type=="newsBase"){
                $Data = $this->getDoctrine()->getManager()->getRepository('App:News')->find($id);
                $comment->setIdNews($Data);
            }
            if ($type=="serviceBase"){
                $Data = $this->getDoctrine()->getManager()->getRepository('App:Service')->find($id);
                $comment->setIdService($Data);
            }
            $comment->setDateInsert(new \DateTime());
            $comment->setName( $_POST['name']);
            $comment->setEmail($_POST['email']);
            $comment->setSubject($_POST['subject']);
            return $comment;
        }

}