<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use function round;
use function strstr;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class DiscountCalculator implements DiscountCalculatorInterface
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

        return Price::create($total->getPrice() - $discountPrice->getPrice());
    }

    /**
     * @param Price $total
     * @param Discount $discount
     * @return Price
     */
    public function calculateDiscountPriceFromTotal(Price $total, Discount $discount): Price
    {
        if ($total->getPrice() === 0) {
            return Price::create(0);
        }

        $totalPrice = $total->getPrice() / 100;

        $calculatedAmount = $totalPrice * $discount->getDiscount();

        $foundAmount = strstr((string) $calculatedAmount, '.');
        if ($foundAmount !== false) {
            $calculatedAmount /= 100;
            $calculatedAmount = round($calculatedAmount, 2);
            $calculatedAmount *= 100;
        }

        return Price::create((int) $calculatedAmount);
    }
}
