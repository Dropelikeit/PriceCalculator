<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

/**
 * Class CentToEuro
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Converter
 */
class CentToEuro implements ConverterInterface
{
    /**
     * @inheritDoc
     */
    public function convert(float $amount): float
    {
        return (float)bcdiv($amount, 100, 2);
    }
}
