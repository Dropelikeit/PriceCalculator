<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\PriceCalculator as PriceCalculatorService;

/**
 * Class PriceCalculator
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Facade
 */
class PriceCalculator
{
    public static function getPriceCalculator(): PriceCalculatorService
    {
        return (new self())->createPriceCalculator();
    }

    private function createPriceCalculator(): PriceCalculatorService
    {
        return new PriceCalculatorService();
    }
}
