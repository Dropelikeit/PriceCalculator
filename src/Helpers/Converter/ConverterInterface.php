<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

use MarcelStrahl\PriceCalculator\Exceptions\ConverterException;

/**
 * Interface ConverterInterface
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Converter
 */
interface ConverterInterface
{
    /**
     * @param float $amount
     * @return float
     * @throws ConverterException
     */
    public function convert(float $amount): float;

    /**
     * @param float $amount
     * @return void
     * @throws ConverterException
     */
    public function isZeroAmount(float $amount): void;
}
