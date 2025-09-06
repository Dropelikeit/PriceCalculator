<?php
declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Exceptions;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(className: PriceCalculatorFactoryException::class)]
final class PriceCalculatorFactoryExceptionTest extends TestCase
{
    #[Test]
    public function canCreateException(): void
    {
        $exception = PriceCalculatorFactoryException::fromUnsupportedArgument(type: 'test');

        $this->assertSame(expected: 500, actual: $exception->getCode());
        $this->assertSame(
            expected: 'The required currency translation is not currently supported. Type: test',
            actual: $exception->getMessage()
        );
    }
}
