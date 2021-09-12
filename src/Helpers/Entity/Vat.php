<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Types\VatInterface;

/**
 * Class Vat
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
class Vat implements VatInterface
{
    /**
     * @var float
     */
    private float $vat = 0;

    /**
     * @return float
     */
    public function getVat(): float
    {
        return $this->vat;
    }

    /**
     * @param float $vat
     * @return void
     */
    public function setVat(float $vat): void
    {
        $this->vat = $vat;
    }
}
