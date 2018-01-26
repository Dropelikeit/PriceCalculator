<?php

namespace MarcelStrahl\PriceCalculator\Exceptions;

/**
 * Class PriceCalculatorFactoryException
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Exceptions
 */
class PriceCalculatorFactoryException extends \InvalidArgumentException
{
    /**
     * @param string $type
     * @throws PriceCalculatorFactoryException
     * @return void
     */
    public static function fromUnsupportedArgument(string $type): void
    {
        throw new PriceCalculatorFactoryException(
            sprintf('The required currency translation is not currently supported. Type: %s', $type)
        );
    }
}
