<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

/**
 * Interface ConverterInterface
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Converter
 */
interface ConverterInterface
{
    /**
     * @return float
     */
    public function convert(): float;
}
