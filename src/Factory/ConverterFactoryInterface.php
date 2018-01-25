<?php

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * Interface FactoryInterface
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Factory
 */
interface ConverterFactoryInterface
{
    /**
     * @param float $amount
     * @param string $currentUnit
     * @param string $newUnit
     * @return ConverterInterface
     */
    public function get(float $amount, string $currentUnit, string $newUnit): ConverterInterface;
}
