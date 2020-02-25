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
     * {@inheritdoc}
     */
    public function addPrice(Price $total, Price $price): Price
    {
        $total->setPrice($total->getPrice() + $price->getPrice());

        return $total;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function mulPrice(Price $amount, Price $price): Price
    {
        $price->setPrice($price->getPrice() * $amount->getPrice());

        return $price;
    }

    /**
     * {@inheritdoc}
     */
    public function divPrice(int $amount, Price $price): Price
    {
        if ($price->getPrice() <= 0) {
            $price->setPrice(0);

            return $price;
        }

        $price->setPrice((int) ($price->getPrice() / $amount));

        return $price;
    }
}
