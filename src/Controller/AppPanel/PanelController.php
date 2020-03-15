<?php
namespace App\Controller\AppPanel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PanelController  extends  AbstractController
{

    public function headerTopAction(){
        return $this->render("AppPanel/Includes/header_top.html.twig",array(
        ));
    }
//    public function menuAction(){
//        return $this->render("AppPanel/Includes/menu.html.twig",array(
//        ));
//    }
    public function panelLastArticleCategoryArticleAction(){

        $CatArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:Article');
        $lastArticle = $CatArticleRepo->findByLimit('panelMainPageTopArticle',7);

        $CatArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:CategoryArticle');
        $lastCatArticle = $CatArticleRepo->findByLimit('panelMainPageTopArticle',4);

        return $this->render("AppPanel/Includes/panel_last_article_category_article.html.twig",array(
            "lastArticles" => $lastArticle,
            "lastCatArticles" => $lastCatArticle,
        ));
    }
    public function panelNewsCategoryAction(){
        $NewsRepo=$this->getDoctrine()->getManager()->getRepository('App:News');
        $lastNews = $NewsRepo->findByLimit('panelNewsCategory',4);

        $CatNewsRepo=$this->getDoctrine()->getManager()->getRepository('App:CategoryNews');
        $lastCatNews = $CatNewsRepo->findByLimit('panelNewsCategory',2);
        return $this->render("AppPanel/Includes/panel_news_category.html.twig",array(
            'lastCatNews' => $lastCatNews,
            'lastNewses' => $lastNews
        ));
    }
    public function panelLastServiceAction(){
        $ServiceRepo=$this->getDoctrine()->getManager()->getRepository('App:Service');
        $lastService = $ServiceRepo->findByLimit('panelLastService',6);
        return $this->render("AppPanel/Includes/panel_last_service.html.twig",array(
            'lastServices' => $lastService,

        ));
    }
    public function panelLastContentAction(){
        ///last news
        $NewsRepo=$this->getDoctrine()->getManager()->getRepository('App:News');
        $lastPanelContentNewses = $NewsRepo->findByLimit('id',10);
        ///last article
        $CatArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:Article');
        $lastPanelContentArticle = $CatArticleRepo->findByLimit('id',10);
        ///content
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Content');
        $lastContent = $Repo->findByLimit('panelContent',1);
        return $this->render("AppPanel/Includes/panel_last_content.html.twig",array(
            'lastContents' =>$lastContent,
            'lastPanelContentNewses'  => $lastPanelContentNewses,
            'lastPanelContentArticles' => $lastPanelContentArticle,
        ));
    }
    public function panelLastProductAction(){
        $ProductRepo=$this->getDoctrine()->getManager()->getRepository('App:Product');
        $lastProducts = $ProductRepo->findByLimit('panelLastProduct',8);
        return $this->render("AppPanel/Includes/panel_last_product.html.twig",array(
            "lastProducts" => $lastProducts
        ));
    }
    public function footerAction(){
        return $this->render("AppPanel/Includes/footer.html.twig",array(
        ));
    }
}