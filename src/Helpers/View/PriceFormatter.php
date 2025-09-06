<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\View;

use MarcelStrahl\PriceCalculator\Contracts\View\Formatter;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class PriceFormatter implements Formatter
{
    /**
     * @var int
     */
    private int $decimals;

    /**
     * @var string
     */
    private string $decPoint;

    /**
     * @var string
     */
    private string $thousandsSep;

    /**
     * @var string
     */
    private string $currency;

    /**
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     * @param string $currency
     */
    public function __construct(int $decimals, string $decPoint, string $thousandsSep, string $currency)
    {
        $this->decimals = $decimals;
        $this->decPoint = $decPoint;
        $this->thousandsSep = $thousandsSep;
        $this->currency = $currency;
    }

    /**
     * {@inheritdoc}
     */
    public function formatPrice(float $price): string
    {
        return number_format($price, $this->decimals, $this->decPoint, $this->thousandsSep) . ' ' . $this->currency;
    }
}
