<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\PriceCalculator as PriceCalculatorService;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class PriceCalculator
{
    public static function getPriceCalculator(): PriceCalculatorInterface
    {
        return (new self())->createPriceCalculator();
    }

    private function createPriceCalculator(): PriceCalculatorInterface
    {
        return new PriceCalculatorService();
    }
}
