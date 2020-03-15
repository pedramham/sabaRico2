<?php
namespace App\Controller\AppPanel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class PanelMenuController  extends  AbstractController
{

    public function menuAction(){
        return $this->render("AppPanel/Includes/menu.html.twig",array(
            'categoryMenuArticles' => $this->categoryMenuArticle(),
            'suggestedMenuArticles'=> $this->suggestedMenuArticle(),
            'lastMenuArticles'     => $this->lastMenuArticle(),
            'suggestedOneNews'     => $this->suggestedOneMenuNews()[0],
            'suggestedMenuServices'=> $this->suggestedMenuService(),
            'categoryMenusServices' => $this->categoryMenuService(),
            'lastMenuContents'     => $this->lastMenuContent(),
            'suggestedOneMenuService' => $this->suggestedOneMenuService()[0],
            'lastMenuNewses'       => $this->lastMenuNews(),
            'categoryMenuNewses'   => $this->categoryMenuNews(),
            'lastMenuProducts'      => $this->lastMenuProduct(),
            'suggestedOneMenuProduct' => $this->suggestedOneMenuProduct()[0],
        ));
    }

    private function categoryMenuArticle(){
        $CatArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:CategoryArticle');
        return $CatArticleRepo->findByLimit("panelMainPageTopArticle",7);
    }
    private function suggestedMenuArticle(){
        $ArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:Article');
        return $ArticleRepo->findByLimit("panelMainPageTopArticle", 7);
      //  return $ArticleRepo->findByLimit(array('displayStatus' => 1), array('panelMainPageTopArticle' => 'DESC'),7);
    }
    private function lastMenuArticle(){
        $ArticleRepo=$this->getDoctrine()->getManager()->getRepository('App:Article');
        return $ArticleRepo->findByLimit("id",7);
    }
    private function suggestedOneMenuNews(){
        $NewsRepo=$this->getDoctrine()->getManager()->getRepository('App:News');
        return $NewsRepo->findByLimit("panelNewsCategory",1);
    }

    private function suggestedMenuService(){
        $ServiceRepo=$this->getDoctrine()->getManager()->getRepository('App:Service');
        return $ServiceRepo->findByLimit("panelLastService",7);
    }
    private function categoryMenuService(){
        $CatServiceRepo=$this->getDoctrine()->getManager()->getRepository('App:CategoryService');
        return $CatServiceRepo->findByLimit("panelLastCatService",7);
    }
    private function lastMenuContent(){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Content');
        return $Repo->findByLimit('panelContent',7);
    }
    private function suggestedOneMenuService(){
        $ServiceRepo=$this->getDoctrine()->getManager()->getRepository('App:Service');
        return $ServiceRepo->findByLimit("panelLastService",1);
    }

    private function lastMenuNews(){
        $NewsRepo=$this->getDoctrine()->getManager()->getRepository('App:News');
        return $NewsRepo->findByLimit("panelNewsCategory",7);
    }
    private function categoryMenuNews(){
        $CatNewsRepo=$this->getDoctrine()->getManager()->getRepository('App:CategoryNews');
        return $CatNewsRepo->findByLimit("panelNewsCategory",7);
    }

    private function lastMenuProduct(){
        $ProductRepo=$this->getDoctrine()->getManager()->getRepository('App:Product');
        return $ProductRepo->findByLimit("panelLastProduct",8);
    }

    private function suggestedOneMenuProduct(){
        $ProductRepo=$this->getDoctrine()->getManager()->getRepository('App:Product');
        return $ProductRepo->findByLimit("panelLastProduct",1);
    }
}