<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use function round;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculator implements VatCalculatorInterface
{
    /**
     * @var Vat
     */
    private Vat $vat;

    /**
     * @var PriceCalculator
     */
    private PriceCalculator $priceCalculator;

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
        $grossPrice /= 100;
        $grossPrice = round($grossPrice, 2);
        // Calculate to cent to be had an int
        $grossPrice *= 100;

        /*
         * We calculate the value of "grossPrice" in cents again, but for PHP the value remains a float.
         * For example, if we have the value 489.0 and we convert it to
         * an integer using "(int)" the result is 488 because PHP rounds down on int-carst.
         * A workaround here is to use round again with precision 0 and then use a safe carst to integer.
         */
        $grossPrice = (int) round($grossPrice);

        $calculatedPrice->setPrice($grossPrice);

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
