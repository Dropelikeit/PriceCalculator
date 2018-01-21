<?php

namespace MarcelStrahl\PriceCalculator;

/**
 * Class PriceCalculator
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package Src
 */
class PriceCalculator
{
    /**
     * @var string
     */
    private $vatToCalculate = '';

    /**
     * @var int
     */
    private $vat = 0;

    /**
     * @param $vatInPercent
     */
    public function __construct(int $vatInPercent)
    {
        $this->vat = $vatInPercent;
        $this->vatToCalculate = bcadd(1, bcdiv($this->vat, 100, 2), 2);
    }

    /**
     * Add an price to total
     *
     * @param int $total
     * @param int $price
     * @return int
     */
    public function addPrice(int $total, int $price): int
    {
        return (int)bcadd($total, $price);
    }

    /**
     * Sub an price from total
     *
     * @param int $total
     * @param int $price
     * @return int
     */
    public function subPrice(int $total, int $price): int
    {
        $total = (int)bcsub($total, $price);
        return ($total < 0) ? 0 : $total;
    }

    /**
     * Mul an price with amount
     *
     * @param int $amount
     * @param int $price
     * @return int
     */
    public function mulPrice(int $amount, int $price): int
    {
        return bcmul($price, $amount);
    }

    /**
     * Calculates the gross price
     *
     * @param int $netPrice
     * @return int
     */
    public function calculatePriceWithSalesTax(int $netPrice): int
    {
        return (int)round((float)bcmul($netPrice, $this->vatToCalculate, 2));
    }

    /**
     * Calculates the value added tax from the current total price
     *
     * @param int $total
     * @return int
     */
    public function calculateSalesTaxFromTotalPrice(int $total) : int
    {
        return (int)bcsub($total, round((float)bcdiv($total, $this->vatToCalculate, 2)));
    }

    /**
     * Calculates the net price from the gross price
     *
     * @param int $total
     * @return int
     */
    public function calculateNetPriceFromGrossPrice(int $total) : int
    {
        $vatPrice = $this->calculateSalesTaxFromTotalPrice($total);
        return $this->subPrice($total, $vatPrice);
    }

    /**
     * Calculate the euro price into cent
     *
     * @param string $total
     * @return int
     */
    public function calculateEuroToCent(string $total): int
    {
        return (int)bcmul($total, 100);
    }

    /**
     * Calculate the cent price to euro
     *
     * @param int $total
     * @return string
     */
    public function calculateCentToEuro(int $total): string
    {
        return bcdiv($total, 100, 2);
    }

    /**
     * @return int
     */
    public function getVat(): int
    {
        return $this->vat;
    }

    /**
     * @return string
     */
    public function getVatToCalculate(): string
    {
        return $this->vatToCalculate;
    }
}
