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
     * @return self
     */
    public static function fromUnsupportedArgument(string $type): self
    {
         return new self(
            sprintf('The required currency translation is not currently supported. Type: %s', $type), 500
        );
    }
}
