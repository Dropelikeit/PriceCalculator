<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class Price
{
    /**
     * @var int
     */
    private int $price = 0;

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
