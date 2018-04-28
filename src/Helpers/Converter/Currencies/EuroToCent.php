<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

use MarcelStrahl\PriceCalculator\Exceptions\ConverterException;

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
        $this->isZeroAmount($amount);
        return (float)bcmul($amount, 100);
    }

    /**
     * @inheritDoc
     */
    public function isZeroAmount(float $amount): void
    {
        if (empty($amount)) {
            throw ConverterException::fromZeroAmount($amount);
        }
    }
}
