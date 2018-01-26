<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

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
    private $vat = 0.00;

    /**
     * @var float
     */
    private $vatToCalculate = 0.00;

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
    public function getVat(): float
    {
        return $this->vat;
    }

    /**
     * @return float
     */
    public function getVatToCalculate(): float
    {
        return $this->vatToCalculate;
    }
}
