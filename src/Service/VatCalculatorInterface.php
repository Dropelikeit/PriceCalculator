<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface VatCalculatorInterface
{
    /**
     * Calculates the gross price
     *
     * @param Price $netPrice
     * @return Price
     */
    public function calculatePriceWithSalesTax(Price $netPrice): Price;

    /**
     * Calculates the value added tax from the current total price
     *
     * @param Price $total
     * @return Price
     */
    public function calculateSalesTaxFromTotalPrice(Price $total): Price;

    /**
     * Calculates the net price from the gross price
     *
     * @param Price $total
     * @return Price
     */
    public function calculateNetPriceFromGrossPrice(Price $total): Price;
}
