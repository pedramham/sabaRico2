<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 10/29/2019
 * Time: 1:55 PM
 */

namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DisplayNotDisplay extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('displayNotDisplay', [$this, 'DisplayNotDisplay']),
            new TwigFilter('colorPosition', [$this, 'colorPosition']),
        ];
    }

    public function DisplayNotDisplay($value)
    {
        if($value == 1){
           $message = "نمایش";
        }
        else{
            $message = "عدم نمایش";
        }

        return $message;
    }
    public function colorPosition($value)
    {
        if($value == 1){
            $color = "#2ea26c";
        }
        else{
            $color = "grey";
        }

        return $color;
    }
}