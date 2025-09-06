<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Contracts\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Contracts\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\EuroToCent;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class Converter implements ConverterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function factorize(string $destinationUnit): ConverterInterface
    {
        return match ($destinationUnit) {
            ConverterFactoryInterface::CENT_TO_EURO => new CentToEuro(),
            ConverterFactoryInterface::EURO_TO_CENT => new EuroToCent(),
            default => throw PriceCalculatorFactoryException::fromUnsupportedArgument(type: $destinationUnit),
        };
    }
}
