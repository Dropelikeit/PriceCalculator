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
     * @var int
     */
    private $decimals;

    /**
     * @var string
     */
    private $decPoint;

    /**
     * @var string
     */
    private $thousandsSep;

    /**
     * @var string
     */
    private $currency;

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
     * @inheritdoc
     */
    public function formatPrice(float $price): string
    {
        // @Todo Maybe we use money_format
        return number_format($price, $this->decimals, $this->decPoint, $this->thousandsSep) . ' ' . $this->currency;
    }
}
