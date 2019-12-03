<?php

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator as PriceCalculatorService;
use MarcelStrahl\PriceCalculator\Service\VatCalculator as VatCalculatorService;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculator
{
    /**
     * @var Vat
     */
    private $vat;

    /**
     * @var PriceCalculatorService
     */
    private $priceCalculator;

    private function __construct()
    {
        $this->vat = new Vat();
        $this->priceCalculator = PriceCalculator::getPriceCalculator();
    }

    public static function getVatCalculator(int $vat): VatCalculatorService
    {
        $instance = new self();
        $instance->vat->setVat($vat);

        return $instance->createVatCalculator();
    }

    private function createVatCalculator()
    {
        return new VatCalculatorService($this->vat, $this->priceCalculator);
    }
}
