<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

use MarcelStrahl\PriceCalculator\Exceptions\ConverterException;

/**
 * Class CentToEuro
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Converter
 */
class CentToEuro implements ConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert(float $amount): float
    {
        $this->isZeroAmount($amount);

        return (float) bcdiv($amount, 100, 2);
    }

    /**
     * {@inheritdoc}
     */
    public function isZeroAmount(float $amount): void
    {
        if (empty($amount)) {
            throw ConverterException::fromZeroAmount($amount);
        }
    }
}
