<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Exceptions\ConverterException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

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
        $this->isZeroAmount($amount);
        return (float)bcdiv($amount, 100, 2);
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
