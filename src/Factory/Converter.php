<?php

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\EuroToCent;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;

/**
 * Class ConverterFactory
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Factory
 */
class Converter implements ConverterFactoryInterface
{
    /**
     * @inheritdoc
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
                PriceCalculatorFactoryException::fromUnsupportedArgument($destinationUnit);
        }

        return $converter;
    }
}
