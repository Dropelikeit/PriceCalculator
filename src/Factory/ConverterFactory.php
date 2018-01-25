<?php

namespace MarcelStrahl\PriceCalculator\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Helpers\Converter\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\EuroToCent;
use MarcelStrahl\PriceCalculator\PriceCalculator;

/**
 * Class ConverterFactory
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Factory
 */
class ConverterFactory implements ConverterFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function get(float $amount, string $currentUnit, string $newUnit): ConverterInterface
    {
        if ($currentUnit === PriceCalculator::EURO_CENT && $newUnit === PriceCalculator::EURO) {
            $converter = new CentToEuro($amount);
        } elseif ($currentUnit === PriceCalculator::EURO && $newUnit === PriceCalculator::EURO_CENT) {
            $converter = new EuroToCent($amount);
        } else {
            throw new PriceCalculatorFactoryException('The required currency translation is not currently supported.');
        }

        return $converter;
    }
}
