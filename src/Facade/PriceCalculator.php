<?php

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator as PriceCalculatorService;

/**
 * Class PriceCalculator
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Facade
 */
class PriceCalculator
{
    /**
     * @var Vat
     */
    private $vat;

    public function __construct()
    {
        $this->vat = new Vat();
    }

    /**
     * @param int $vat
     * @return PriceCalculatorService
     */
    public static function getPriceCalculator(int $vat)
    {
        return (new self())->createPriceCalculator($vat);
    }

    /**
     * @param int $vat
     * @return PriceCalculatorService
     */
    private function createPriceCalculator(int $vat): PriceCalculatorService
    {
        $this->vat->setVat($vat);
        return new PriceCalculatorService($this->vat);
    }
}
