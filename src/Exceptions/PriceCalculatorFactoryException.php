<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Exceptions;

use InvalidArgumentException;

use function sprintf;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class PriceCalculatorFactoryException extends InvalidArgumentException
{
    public static function fromUnsupportedArgument(string $type): self
    {
        return new self(
            sprintf('The required currency translation is not currently supported. Type: %s', $type),
            500
        );
    }
}
