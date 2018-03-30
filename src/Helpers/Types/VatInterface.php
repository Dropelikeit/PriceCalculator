<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Types;

/**
 * Interface VatInterface
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
interface VatInterface
{
    /**
     * @param float $vat
     * @return void
     */
    public function setVat(float $vat): void;

    /**
     * @return float
     */
    public function getVat(): float;

    /**
     * @return float
     */
    public function getVatToCalculate(): float;
}
