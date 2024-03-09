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
        $exception = PriceCalculatorFactoryException::fromUnsupportedArgument('test');

        $this->assertSame(500, $exception->getCode());
        $this->assertSame(
            'The required currency translation is not currently supported. Type: test',
            $exception->getMessage()
        );
    }
}
