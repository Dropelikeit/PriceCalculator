<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Exceptions\ConverterException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

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
