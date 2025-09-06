<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Service;

use MarcelStrahl\PriceCalculator\Contracts\PriceCalculatorInterface;
use MarcelStrahl\PriceCalculator\Contracts\Service\VatCalculatorInterface;
use MarcelStrahl\PriceCalculator\Contracts\Type\FiguresInterface;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use function round;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class VatCalculator implements VatCalculatorInterface
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
        $vatPrice = $netPrice->getPrice() * ($this->vat->getVat() / FiguresInterface::INTEGER_HUNDRED);
        $grossPrice = $netPrice->getPrice() + $vatPrice;
        // Calculate to Euro for round the number if necessary
        $grossPrice /= FiguresInterface::INTEGER_HUNDRED;
        $grossPrice = round(num: $grossPrice, precision: FiguresInterface::INTEGER_TWO);
        // Calculate to cent to be had an int
        $grossPrice *= FiguresInterface::INTEGER_HUNDRED;

        /*
         * We calculate the value of "grossPrice" in cents again, but for PHP the value remains a float.
         * For example, if we have the value 489.0 and we convert it to
         * an integer using "(int)" the result is 488 because PHP rounds down on int-carst.
         * A workaround here is to use round again with precision 0 and then use a safe carst to integer.
         */
        /** @infection-ignore-all */
        $grossPrice = (int) round(num: $grossPrice);

        return Price::create(price: $grossPrice);
    }

    /**
     * Calculates the value added tax from the current total price
     *
     * @param Price $total
     * @return Price
     */
    public function calculateSalesTaxFromTotalPrice(Price $total): Price
    {
        $toCalculatingVatPrice = Price::create(price: $total->getPrice());

        $vatToCalculate = FiguresInterface::INTEGER_ONE + ($this->vat->getVat() / FiguresInterface::INTEGER_HUNDRED);

        $calculatedPrice = (int) (round(num: $toCalculatingVatPrice->getPrice() / $vatToCalculate, precision: FiguresInterface::INTEGER_ZERO));

        $calculatedPrice = $total->getPrice() - $calculatedPrice;

        return Price::create(price: $calculatedPrice);
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
