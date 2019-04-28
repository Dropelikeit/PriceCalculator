<?php

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\EuroToCent;

/**
 * Class ConverterFactory
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Factory
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
