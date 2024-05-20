<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Contracts;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator
 */
interface PriceCalculatorInterface
{
    /**
     * @param Price $total
     * @param Price $price
     * @return Price
     */
    public function addPrice(Price $total, Price $price): Price;

    /**
     * Sub an price from total
     *
     * @param Price $total
     * @param Price $price
     * @return Price
     */
    public function subPrice(Price $total, Price $price): Price;

    /**
     * Mul an price with amount
     *
     * @param Price $amount
     * @param Price $price
     * @return Price
     */
    public function mulPrice(Price $amount, Price $price): Price;

    /**
     * @param int $amount
     * @param Price $price
     * @return Price
     */
    public function divPrice(int $amount, Price $price): Price;
}
