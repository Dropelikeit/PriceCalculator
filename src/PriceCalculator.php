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
        return Price::create($total->getPrice() + $price->getPrice());
    }

    /**
     * {@inheritdoc}
     */
    public function subPrice(Price $total, Price $price): Price
    {
        $calculated = Price::create($total->getPrice() - $price->getPrice());

        if ($calculated->getPrice() < 0) {
            return Price::create(0);
        }

        return $calculated;
    }

    /**
     * {@inheritdoc}
     */
    public function mulPrice(Price $amount, Price $price): Price
    {
        return Price::create($price->getPrice() * $amount->getPrice());
    }

    /**
     * {@inheritdoc}
     */
    public function divPrice(int $amount, Price $price): Price
    {
        if ($price->getPrice() <= 0) {
            return Price::create(0);
        }

        return Price::create((int) ($price->getPrice() / $amount));
    }
}
