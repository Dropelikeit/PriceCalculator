<?php

namespace MarcelStrahl\PriceCalculator;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class PriceCalculator implements PriceCalculatorInterface
{

    /**
     * {@inheritDoc}
     */
    public function addPrice(Price $total, Price $price): Price
    {
        $total->setPrice($total->getPrice() + $price->getPrice());

        return $total;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function mulPrice(Price $amount, Price $price): Price
    {
        $price->setPrice($price->getPrice() * $amount->getPrice());

        return $price;
    }

    /**
     * {@inheritDoc}
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
