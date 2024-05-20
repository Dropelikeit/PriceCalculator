<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\Contracts\PriceCalculatorInterface;
use MarcelStrahl\PriceCalculator\PriceCalculator as PriceCalculatorService;

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
