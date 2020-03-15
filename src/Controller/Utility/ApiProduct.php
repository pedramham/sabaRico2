<?php
/**
 * Created by PhpStorm.
 * User: mori
 * Date: 03/02/20
 * Time: 16:55
 */

namespace App\Controller\Utility;
use App\Twig\CalculateDiscount;

class ApiProduct
{

    public function apiJson($DateEntities, $type = null)
    {
        $calculateDiscount = new CalculateDiscount();
        $finalOut = array();
        foreach ($DateEntities as $dateEntity) {
            $price = $calculateDiscount->price($dateEntity->getPrice(),$dateEntity->getDiscount());
            $price = $calculateDiscount->roundToThousand($price);
            $parameter = array('name' => $dateEntity->getName(), 'smallPic' => "/uploads/product/" . $dateEntity->getSmallPic(),
                'url' => "/Product/".$dateEntity->getId()."/".$dateEntity->getUrlslug(),'title'=>$dateEntity->getTitle(),
                'price'=>$price,'discount'=>$dateEntity->getPrice());
            array_push($finalOut, $parameter);

        }
        $outPutJson['items']=$finalOut;

        return $outPutJson;
    }
}