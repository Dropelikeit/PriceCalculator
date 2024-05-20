<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use function is_string;
use MarcelStrahl\PriceCalculator\Contracts\Service\DiscountCalculatorInterface;
use MarcelStrahl\PriceCalculator\Contracts\Type\FiguresInterface;
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
        if (($discountPrice = $this->calculateDiscountPriceFromTotal($total, $discount))->getPrice() === FiguresInterface::INTEGER_ZERO) {
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
        if ($total->getPrice() === FiguresInterface::INTEGER_ZERO) {
            return Price::create(FiguresInterface::INTEGER_ZERO);
        }

        $totalPrice = $total->getPrice() / FiguresInterface::INTEGER_HUNDRED;

        $calculatedAmount = $totalPrice * $discount->getDiscount();

        $foundAmount = strstr((string) $calculatedAmount, '.');

        if (!is_string($foundAmount)) {
            return Price::create((int) $calculatedAmount);
        }

        $calculatedAmount /= FiguresInterface::INTEGER_HUNDRED;
        $calculatedAmount = round($calculatedAmount, FiguresInterface::INTEGER_TWO);
        $calculatedAmount *= FiguresInterface::INTEGER_HUNDRED;

        return Price::create((int) $calculatedAmount);
    }
}
