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

class ConvertDollarsToRials extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('convertToRial', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($number)
    {
        $salePriceText = str_replace('$', '', $number);
        $price = $salePriceText * 1000;
        $numPrice = $price / 1000;
        $numPrice = round($numPrice);
        $price = $numPrice * 1000;

        return $price;
    }
}