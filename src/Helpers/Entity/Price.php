<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class Price
{
    private function __construct(private int $price)
    {
    }

    public static function create(int $price): self
    {
        return new self(price: $price);
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
