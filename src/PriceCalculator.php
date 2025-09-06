<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator;

use MarcelStrahl\PriceCalculator\Contracts\PriceCalculatorInterface;
use MarcelStrahl\PriceCalculator\Contracts\Type\FiguresInterface;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class PriceCalculator implements PriceCalculatorInterface
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
        $calculated = Price::create(price: $total->getPrice() - $price->getPrice());

        /** @infection-ignore-all  */
        if ($calculated->getPrice() < FiguresInterface::INTEGER_ZERO) {
            return Price::create(price: FiguresInterface::INTEGER_ZERO);
        }

        return $calculated;
    }

    /**
     * {@inheritdoc}
     */
    public function mulPrice(Price $amount, Price $price): Price
    {
        return Price::create(price: $price->getPrice() * $amount->getPrice());
    }

    /**
     * {@inheritdoc}
     */
    public function divPrice(int $amount, Price $price): Price
    {
        if ($amount <= FiguresInterface::INTEGER_ZERO) {
            return Price::create(price: FiguresInterface::INTEGER_ZERO);
        }

        return Price::create(price: (int) ($price->getPrice() / $amount));
    }
}
