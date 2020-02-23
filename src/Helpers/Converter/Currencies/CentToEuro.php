<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class CentToEuro implements ConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert(float $amount): float
    {
        if ($this->isEmpty($amount)) {
            return .0;
        }

        return (float) bcdiv((string) $amount, '100', 2);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(float $amount): bool
    {
        return empty($amount) || $amount < 0;
    }
}
