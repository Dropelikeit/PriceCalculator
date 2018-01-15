<?php

namespace MarcelStrahl\PriceCalculator\Helpers\View;

/**
 * Interface Formatter
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package Src\Helpers\View
 */
interface Formatter
{
    /**
     * Format price for views
     * @param float $price
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     * @param string $currency
     * @return string
     */
    public function formatPrice(
        float $price,
        ?int $decimals = 2,
        ?string $decPoint = ',',
        ?string $thousandsSep = '.',
        ?string $currency = '€'
    ): string;
}
