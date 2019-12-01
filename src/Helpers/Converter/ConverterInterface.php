<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface ConverterInterface
{
    /**
     * @param float $amount
     * @return float
     */
    public function convert(float $amount): float;

    /**
     * @param float $amount
     * @return bool
     */
    public function isEmpty(float $amount): bool;
}
