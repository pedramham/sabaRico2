<?php
namespace App\Controller\AppPanel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PanelProductController  extends  AbstractController
{

    public function panelRightLastProductAction($id = 0){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Product');
        $panelRightLastProduct = $Repo->findByExceptId($id,8);
        return $this->render("AppPanel/Includes/Product/panel_right_last_product.html.twig",array(
            "panelRightLastProducts" => $panelRightLastProduct
        ));
    }
    public function panelRightSuggestedProductAction(){
        $Repo=$this->getDoctrine()->getManager()->getRepository('App:Product');
        $Product = $Repo->findByLimit('panelLastProduct',1);
        return $this->render("AppPanel/Includes/Product/panel_right_suggested_product.html.twig",array(
            "suggestedProduct" => $Product[0]
        ));
    }


}