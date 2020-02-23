<?php

declare(strict_types=1);

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
     * @return string
     */
    public function formatPrice(float $price): string;
}
