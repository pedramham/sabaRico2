<?php
/**
 * Created by PhpStorm.
 * User: mori
 * Date: 30/01/20
 * Time: 14:20
 */

namespace App\Controller\Utility;
use App\Controller\Utility\FactoryUtility;
use SymfonyPersia\JalaliDateBundle\lib\JalaliDateTime ;

class AppApi
{
    private $dateJalali;
    private $finalOut =array();
    private $MbSubstr;
    public function __construct()
    {
        $this->dateJalali = new JalaliDateTime(true, true, 'Asia/Tehran');
        $this->MbSubstr = new FactoryUtility();
    }

    /*
     * @param array $DateEntities
     * @param string $type
     * @return array
     */
    public function apiJson($DateEntities,$type =null){
        foreach ($DateEntities as $dateEntity){
            $subject =  $this->MbSubstr->MbSubstr($dateEntity->getSubject(),0, 200);
            $parameter = array('title'=>$dateEntity->getTitle(),'smallPic'=> "/uploads/articles/".$dateEntity->getSmallPic(),
                'name'=>$dateEntity->getName(),'subject'=> $subject,'authorName' =>$this->getAuthorName($dateEntity),
                'dateInsert'=>  $this->dateJalali->date("Y/m/d", false,  $dateEntity->getDateInsert()->format("Y/m/d")),
                'url'=>$this->getUrl($type,$dateEntity));
            array_push($this->finalOut,$parameter);
        }

        $outPutJson['items']=$this->finalOut;

        return $outPutJson;
    }
    private function getAuthorName($data){
        if (property_exists($data,'authorName'))
        {
             return $data->getAuthorName();
        }else
            {
                return "";
            }
    }
    private function getUrl($type,$data){
        switch ($type) {
            case "CatArticle":
                return "/".$type."/".$data->getId()."/".$data->getUrlSlug();
            case "Article":
                return "/".$type."/".$data->getId()."/".$data->getUrlSlug();
                die();
            case "CatNews":
                return "/".$type."/".$data->getId()."/".$data->getUrlSlug();
            case "News":
                return "/News/".$data->getId()."/".$data->getUrlSlug();
            case "Service":
                return "/".$type."/".$data->getId()."/".$data->getUrlSlug();
            case "ServiceCategory":
                return "/".$type."/".$data->getId()."/".$data->getUrlSlug();
            case "Content":
                return "/".$type."/".$data->getId()."/".$data->getUrlSlug();
        }
    }

}