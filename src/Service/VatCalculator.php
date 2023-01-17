<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use function round;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculator implements VatCalculatorInterface
{
    private Vat $vat;
    private PriceCalculatorInterface $priceCalculator;

    public function __construct(Vat $vat, PriceCalculatorInterface $priceCalculator)
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

        return Price::create($grossPrice);
    }

    /**
     * Calculates the value added tax from the current total price
     *
     * @param Price $total
     * @return Price
     */
    public function calculateSalesTaxFromTotalPrice(Price $total): Price
    {
        $toCalculatingVatPrice = Price::create($total->getPrice());

        $vatToCalculate = 1 + ($this->vat->getVat() / 100);

        $calculatedPrice = (int) (round($toCalculatingVatPrice->getPrice() / $vatToCalculate, 0));

        $calculatedPrice = $total->getPrice() - $calculatedPrice;

        return Price::create($calculatedPrice);
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
