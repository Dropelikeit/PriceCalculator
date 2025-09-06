<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Exceptions;

use InvalidArgumentException;

use function sprintf;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class PriceCalculatorFactoryException extends InvalidArgumentException
{
    private const MESSAGE = 'The required currency translation is not currently supported. Type: %s';

    public static function fromUnsupportedArgument(string $type): self
    {
        return new self(
            message: sprintf(self::MESSAGE, $type),
            code: 500
        );
    }
}
