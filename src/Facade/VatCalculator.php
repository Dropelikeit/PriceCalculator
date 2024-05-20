<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\Contracts\PriceCalculatorInterface;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Service\VatCalculator as VatCalculatorService;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculator
{
    private function __construct(private Vat $vat, private PriceCalculatorInterface $priceCalculator)
    {
    }

    public static function getVatCalculator(int $vat): VatCalculatorService
    {
        return (new self(Vat::create($vat), PriceCalculator::getPriceCalculator()))->createVatCalculator();
    }

    private function createVatCalculator(): VatCalculatorService
    {
        return new VatCalculatorService($this->vat, $this->priceCalculator);
    }
}
