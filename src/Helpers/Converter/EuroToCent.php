<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

/**
 * Class EuroToCent
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Converter
 */
class EuroToCent implements ConverterInterface
{
    /**
     * @inheritDoc
     */
    public function convert(float $amount): float
    {
        return (float)bcmul($amount, 100);
    }
}
