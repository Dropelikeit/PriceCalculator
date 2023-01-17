<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface ConverterFactoryInterface
{
    public const CENT_TO_EURO = 'cent_to_euro';
    public const EURO_TO_CENT = 'euro_to_cent';

    /**
     * @param string $destinationUnit
     * @return ConverterInterface
     * @throws PriceCalculatorFactoryException
     */
    public function factorize(string $destinationUnit): ConverterInterface;
}
