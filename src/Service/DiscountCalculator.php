<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class DiscountCalculator
{
    /**
     * @param Price $total
     * @param Discount $discount
     * @return Price
     */
    public function calculateDiscountFromTotal(Price $total, Discount $discount): Price
    {
        if (($discountPrice = $this->calculateDiscountPriceFromTotal($total, $discount))->getPrice() === 0) {
            return $discountPrice;
        }

        $total->setPrice($total->getPrice() - $discountPrice->getPrice());

        return $total;
    }

    /**
     * @param Price $total
     * @param Discount $discount
     * @return Price
     */
    public function calculateDiscountPriceFromTotal(Price $total, Discount $discount): Price
    {
        if ($total->getPrice() === 0) {
            return $total;
        }

        $totalPrice = $total->getPrice() / 100;

        $calculated = new Price();
        $calculated->setPrice((int)$totalPrice * $discount->getDiscount());

        return $calculated;
    }
}
