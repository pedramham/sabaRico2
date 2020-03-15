<?php
/**
 * Created by PhpStorm.
 * User: mori
 * Date: 27/01/20
 * Time: 05:02
 */

namespace App\Twig;

namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
class CalculateDiscount  extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('discount', [$this, 'price']),
            new TwigFilter('roundToThousand', array($this, 'roundToThousand')),
        ];
    }

    public function price($price,$discountPrice)
    {

        $numDiscountPrice = 100 - $discountPrice;
        $numDiscountPrice = $numDiscountPrice * $price;
        $numDiscountPrice = $numDiscountPrice / 100;
        $numDiscountPrice = $numDiscountPrice / 1000;
        $numDiscountPrice = round($numDiscountPrice);
        $numDiscountPrice = $numDiscountPrice * 1000;
        return $numDiscountPrice;
    }
    public function roundToThousand($price)
    {
        $numDiscountPrice = $price / 1000;
        $numDiscountPrice = round($numDiscountPrice);
        $numDiscountPrice = $numDiscountPrice * 1000;
        return $numDiscountPrice;
    }
}