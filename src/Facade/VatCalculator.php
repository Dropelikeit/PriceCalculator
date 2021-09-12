<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator as PriceCalculatorService;
use MarcelStrahl\PriceCalculator\Service\VatCalculator as VatCalculatorService;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculator
{
    private Vat $vat;

    private PriceCalculatorService $priceCalculator;

    private function __construct()
    {
        $this->vat = new Vat();
        $this->priceCalculator = PriceCalculator::getPriceCalculator();
    }

    public static function getVatCalculator(float $vat): VatCalculatorService
    {
        $instance = new self();
        $instance->vat->setVat($vat);

        return $instance->createVatCalculator();
    }

    private function createVatCalculator(): VatCalculatorService
    {
        return new VatCalculatorService($this->vat, $this->priceCalculator);
    }
}
