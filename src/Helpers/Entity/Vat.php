<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Types\VatInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class Vat implements VatInterface
{
    private int $vat = 0;

    public function getVat(): int
    {
        return $this->vat;
    }

    public function setVat(int $vat): void
    {
        $this->vat = $vat;
    }
}
