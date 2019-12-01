<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class EuroToCent implements ConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert(float $amount): float
    {
        if ($this->isEmpty($amount)) {
            return 0;
        }

        return (float) bcmul((string)$amount, '100');
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty(float $amount): bool
    {
        return empty($amount) || $amount < 0;
    }
}
