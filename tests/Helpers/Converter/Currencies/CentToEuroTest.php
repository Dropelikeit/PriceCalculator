<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: CentToEuro::class)]
final class CentToEuroTest extends TestCase
{
    #[Test]
    public function hasImplemented(): void
    {
        $converter = new CentToEuro();
        $this->assertInstanceOf(ConverterInterface::class, $converter);
        $this->assertInstanceOf(CentToEuro::class, $converter);
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderConvert')]
    public function testConvert(float $amount, float $expected): void
    {
        $converter = new CentToEuro();

        $this->assertSame($expected, $converter->convert($amount));
    }

    /**
     * @return array{
     *     0: array{0: 100.00, 1: 1.00},
     *     1: array{0: 250.00, 1: 2.50},
     *     2: array{0: 178, 1: 1.78},
     *     3: array{0: .00, 1: 0}
     * }
     */
    public static function dataProviderConvert(): array
    {
        return [
            [100.00, 1.00],
            [250.00, 2.50],
            [178, 1.78],
            [.00, 0],
        ];
    }
}
