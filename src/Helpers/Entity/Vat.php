<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Types\PercentInterface;
use MarcelStrahl\PriceCalculator\Helpers\Types\VatInterface;

/**
 * Class Vat
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
class Vat implements VatInterface, PercentInterface
{
    /**
     * @var float
     */
    private $vat = .00;

    /**
     * @var float
     */
    private $vatToCalculate = .00;

    /**
     * @return float
     */
    public function getVat(): float
    {
        return $this->vat;
    }

    /**
     * @param float $vat
     */
    public function setVat(float $vat): void
    {
        $this->vat = $vat;
        $this->vatToCalculate = (float)bcadd(1, bcdiv($vat, 100, 2), 2);
    }

    /**
     * @return float
     */
    public function getVatToCalculate(): float
    {
        return $this->vatToCalculate;
    }
}
