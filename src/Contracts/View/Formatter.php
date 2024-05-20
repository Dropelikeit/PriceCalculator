<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Contracts\View;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface Formatter
{
    /**
     * Format price for views
     * @param float $price
     * @return string
     */
    public function formatPrice(float $price): string;
}
