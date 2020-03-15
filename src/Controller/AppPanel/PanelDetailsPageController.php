<?php
namespace App\Controller\AppPanel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PanelDetailsPageController  extends  AbstractController
{

    public function panelRightLastArticleAction($id = 0){
        $lastArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:Article');
        $panelRightLastArticle = $lastArticleRepo->findByExceptId($id,14);
        return $this->render("AppPanel/Includes/PanelRight/panel_right_last_article.html.twig",array(
            "panelRightLastArticles" => $panelRightLastArticle
        ));
    }

    public function panelRightMostPopularServiceAction(){
        $ServiceRepo=$this->getDoctrine()->getManager()->getRepository('App:Service');
        $mostPopularService = $ServiceRepo->findByLimit("panelLastService",1);
        return $this->render("AppPanel/Includes/PanelRight/panel_right_most_popular_service.html.twig",array(
            "mostPopularService" => $mostPopularService[0]
        ));
    }
    public function panelRightLastNewsAction(){
        $NewsRepo=$this->getDoctrine()->getManager()->getRepository('App:News');
        $lastNews = $NewsRepo->findByLimit("panelNewsCategory",14);
        return $this->render("AppPanel/Includes/PanelRight/panel_right_last_news.html.twig",array(
            "lastNewses" => $lastNews
        ));
    }
    public function panelRightLastContentAction(){
        $ContentRepo=$this->getDoctrine()->getManager()->getRepository('App:Content');
        $lastContent = $ContentRepo->findByLimit('panelContent',1);
        return $this->render("AppPanel/Includes/PanelRight/panel_right_last_content.html.twig",array(
            "lastContent" => $lastContent[0]
        ));
    }
    public function panelRightSuggestedContent1Action(){
        $ContentRepo=$this->getDoctrine()->getManager()->getRepository('App:Content');
        $lastContent = $ContentRepo->findByLimit('panelContent',1);
        return $this->render("AppPanel/Includes/PanelRight/panel_right_suggested_content_1.html.twig",array(
            "suggestedContent1" => $lastContent[0]
        ));
    }
    public function panelRightLastServiceAction(){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Service');
        $lastService = $Repo->findByLimit("panelLastService",6);
        return $this->render("AppPanel/Includes/PanelRight/panel_right_last_service.html.twig",array(
            "lastServices" => $lastService
        ));
    }
    public function panelBottomLastCategoryArticle(){
        $CatArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:CategoryArticle');
        $lastCatArticle = $CatArticleRepo->findByLimit("panelMainPageTopArticle",7);
        return $this->render("AppPanel/Includes/PanelBottom/panel_bottom_last_category_article.html.twig",array(
            "lastCatArticles" => $lastCatArticle
        ));
    }
    public function panelBottomRelateArticle($idCategory,$id){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Article');
        $lastRelateArticle = $Repo->findByRelateArticle($idCategory,$id,15);
        return $this->render("AppPanel/Includes/PanelBottom/panel_bottom_relate_article.html.twig",array(
            "lastRelateArticles" => $lastRelateArticle
        ));
    }
    public function panelBottomRelateNews($idCategory,$id){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:News');
        $lastRelateNews =$Repo->findByRelateNews($idCategory,$id,15);
        return $this->render("AppPanel/Includes/PanelBottom/panel_bottom_relate_news.html.twig",array(
            "lastRelateNewses" => $lastRelateNews
        ));
    }
    public function panelBottomLastCategoryNews(){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:CategoryNews');
        $lastCatNews = $Repo->findByLimit("panelNewsCategory",15);
        return $this->render("AppPanel/Includes/PanelBottom/panel_bottom_last_category_news.html.twig",array(
            "lastCatNewses" => $lastCatNews
        ));
    }
    public function panelRightMostPopularArticleAction($id){
    //    var_dump($id);die();
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Article');
        $panelRightLastArticle = $Repo->findByExceptIdCategory($id,1);
        return $this->render("AppPanel/Includes/PanelRight/panel_right_most_popular_article.html.twig",array(
            "mostPopularArticles" => $panelRightLastArticle[0]
        ));
    }

    public function panelBottomRelateService($idCategory,$id){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Service');
        $lastRelateService = $Repo->findByRelateService($idCategory,$id,15);
        return $this->render("AppPanel/Includes/PanelBottom/panel_bottom_relate_service.html.twig",array(
            "lastRelateServices" => $lastRelateService
        ));
    }
}