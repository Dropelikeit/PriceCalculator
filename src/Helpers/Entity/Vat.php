<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Contracts\Type\VatInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class Vat implements VatInterface
{
    private function __construct(private int $vat)
    {
    }

    public static function create(int $vat): self
    {
        return new self($vat);
    }

    public function getVat(): int
    {
        return $this->vat;
    }
}
