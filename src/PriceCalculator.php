<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class PriceCalculator implements PriceCalculatorInterface
{

    /**
     * Add an price to total
     *
     * @param Price $total
     * @param Price $price
     * @return Price
     */
    public function addPrice(Price $total, Price $price): Price
    {
        $total->setPrice($total->getPrice() + $price->getPrice());

        return $total;
    }

    /**
     * Sub an price from total
     *
     * @param Price $total
     * @param Price $price
     * @return Price
     */
    public function subPrice(Price $total, Price $price): Price
    {
        $total->setPrice($total->getPrice() - $price->getPrice());

        if ($total->getPrice() < 0) {
            $total->setPrice(0);
        }

        return $total;
    }

    /**
     * Mul an price with amount
     *
     * @param int $amount
     * @param Price $price
     * @return Price
     */
    public function mulPrice(int $amount, Price $price): Price
    {
        $price->setPrice($price->getPrice() * $amount);

        return $price;
    }

    /**
     * @param int $amount
     * @param Price $price
     * @return Price
     */
    public function divPrice(int $amount, Price $price): Price
    {
        if ($price->getPrice() <= 0) {
            $price->setPrice(0);

            return $price;
        }

        $price->setPrice($price->getPrice() / $amount);

        return $price;
    }
}
