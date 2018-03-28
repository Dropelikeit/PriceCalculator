<?php

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * Interface FactoryInterface
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Factory
 */
interface ConverterFactoryInterface
{
    public const CENT_TO_EURO = 'cent_to_euro';
    public const EURO_TO_CENT = 'euro_to_cent';
    public const VAT = 'vat';

    /**
     * @param string $destinationUnit
     * @return ConverterInterface
     */
    public function factorize(string $destinationUnit): ConverterInterface;
}
