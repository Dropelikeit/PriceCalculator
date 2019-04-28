<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculator
{
    /**
     * @var Vat
     */
    private $vat;

    /**
     * @var PriceCalculator
     */
    private $priceCalculator;

    public function __construct(Vat $vat, PriceCalculator $priceCalculator)
    {
        $this->vat = $vat;
        $this->priceCalculator = $priceCalculator;
    }

    /**
     * Calculates the gross price
     *
     * @param Price $netPrice
     * @return Price
     */
    public function calculatePriceWithSalesTax(Price $netPrice): Price
    {
        $calculatedPrice = new Price();

        $vatPrice = $netPrice->getPrice() * ($this->vat->getVat() / 100);
        $grossPrice = $netPrice->getPrice() + $vatPrice;
        // Calculate to Euro for round the number if necessary
        $grossPrice = $grossPrice / 100;
        $grossPrice = round($grossPrice, 2);
        // Calculate to cent to be have a int
        $grossPrice = $grossPrice * 100;

        // It's an integer but php thinks it's an float..
        $calculatedPrice->setPrice((int) $grossPrice);

        return $calculatedPrice;
    }

    /**
     * Calculates the value added tax from the current total price
     *
     * @param Price $total
     * @return Price
     */
    public function calculateSalesTaxFromTotalPrice(Price $total): Price
    {
        $toCalculatingVatPrice = new Price();
        $toCalculatingVatPrice->setPrice($total->getPrice());

        $vatToCalculate = 1 + ($this->vat->getVat() / 100);

        $calculatedPrice = (int) (round($toCalculatingVatPrice->getPrice() / $vatToCalculate, 0));

        $calculatedTotal = new Price();

        $calculatedPrice = $total->getPrice() - $calculatedPrice;

        $calculatedTotal->setPrice($calculatedPrice);

        return $calculatedTotal;
    }

    /**
     * Calculates the net price from the gross price
     *
     * @param Price $total
     * @return Price
     */
    public function calculateNetPriceFromGrossPrice(Price $total): Price
    {
        $vatPrice = $this->calculateSalesTaxFromTotalPrice($total);

        return $this->priceCalculator->subPrice($total, $vatPrice);
    }
}
