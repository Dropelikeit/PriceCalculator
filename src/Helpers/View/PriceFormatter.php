<?php

namespace MarcelStrahl\PriceCalculator\Helpers\View;

/**
 * Class PriceFormatter
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package Src\Helpers\View
 */
class PriceFormatter implements Formatter
{
    /**
     * @inheritdoc
     */
    public function formatPrice(
        float $price,
        ?int $decimals = 2,
        ?string $decPoint = '',
        ?string $thousandsSep = '',
        ?string $currency = '€'
    ): string {
        return number_format($price, $decimals, $decPoint, $thousandsSep).' '.$currency;
    }
}
