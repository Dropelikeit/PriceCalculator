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
final class DiscountCalculator implements DiscountCalculatorInterface
{
    private const NEEDLE_FLOAT_SEPARATOR = '.';

    /**
     * @param Price $total
     * @param Discount $discount
     * @return Price
     */
    public function calculateDiscountFromTotal(Price $total, Discount $discount): Price
    {
        $discountPrice = $this->calculateDiscountPriceFromTotal(total: $total, discount: $discount);
        if ($discountPrice->getPrice() === FiguresInterface::INTEGER_ZERO) {
            return $discountPrice;
        }

        return Price::create(price: $total->getPrice() - $discountPrice->getPrice());
    }

    /**
     * @param Price $total
     * @param Discount $discount
     * @return Price
     */
    public function calculateDiscountPriceFromTotal(Price $total, Discount $discount): Price
    {
        if ($total->getPrice() === FiguresInterface::INTEGER_ZERO) {
            return Price::create(price: FiguresInterface::INTEGER_ZERO);
        }

        $totalPrice = $total->getPrice() / FiguresInterface::INTEGER_HUNDRED;

        $calculatedAmount = $totalPrice * $discount->getDiscount();

        $foundAmount = strstr(haystack: (string) $calculatedAmount, needle: self::NEEDLE_FLOAT_SEPARATOR);

        if (!is_string(value: $foundAmount)) {
            return Price::create(price: (int) $calculatedAmount);
        }

        $calculatedAmount /= FiguresInterface::INTEGER_HUNDRED;
        $calculatedAmount = round(num: $calculatedAmount, precision: FiguresInterface::INTEGER_TWO);
        $calculatedAmount *= FiguresInterface::INTEGER_HUNDRED;

        return Price::create(price: (int) $calculatedAmount);
    }
}
