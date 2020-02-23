<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\EuroToCent;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class Converter implements ConverterFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function factorize(string $destinationUnit): ConverterInterface
    {
        switch ($destinationUnit) {
            case ConverterFactoryInterface::CENT_TO_EURO:
                $converter = new CentToEuro();

                break;
            case ConverterFactoryInterface::EURO_TO_CENT:
                $converter = new EuroToCent();

                break;
            default:
                throw PriceCalculatorFactoryException::fromUnsupportedArgument($destinationUnit);
        }

        return $converter;
    }
}
