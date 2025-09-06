<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Contracts\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Contracts\Type\FiguresInterface;

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
        if ($this->isEmpty(amount: $amount)) {
            return FiguresInterface::FLOAT_ZERO;
        }

        return (float) bcdiv(num1: (string) $amount, num2: FiguresInterface::STRING_HUNDRED, scale: FiguresInterface::INTEGER_TWO);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(float $amount): bool
    {
        return empty($amount);
    }
}
