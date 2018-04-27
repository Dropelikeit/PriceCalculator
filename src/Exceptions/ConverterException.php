<?php

namespace MarcelStrahl\PriceCalculator\Exceptions;

use Exception;

/**
 * Class ConverterException
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Exceptions
 */
class ConverterException extends Exception
{
    /**
     * @param float $amout
     * @return ConverterException
     */
    public static function fromZeroAmount(float $amout): self
    {
        return new self(
            sprintf('Division by zero is not allowed. Please check your injection. Given amount: %f', $amout)
        );
    }
}
