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

    public function __construct(
        int $decimals,
        string $decPoint,
        string $thousandsSep,
        string $currency
    ) {
        $this->decimals = $decimals;
        $this->decPoint = $decPoint;
        $this->thousandsSep = $thousandsSep;
        $this->currency = $currency;
    }

    public function formatPrice(float $price): string
    {
        /*
        * @todo Maybe we use money_format
        */
        return number_format(
                $price, $this->decimals, $this->decPoint, $this->thousandsSep
            ) . ' ' . $this->currency;
    }
}
