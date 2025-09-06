<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Contracts\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\EuroToCent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: EuroToCent::class)]
final class EuroToCentTest extends TestCase
{
    #[Test]
    public function hasImplemented(): void
    {
        $converter = new EuroToCent();
        $this->assertInstanceOf(expected: ConverterInterface::class, actual: $converter);
        $this->assertInstanceOf(expected: EuroToCent::class, actual: $converter);
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderConvert')]
    public function canConvert(float $amount, ?float $expected): void
    {
        $converter = new EuroToCent();

        $this->assertSame(expected: $expected, actual: $converter->convert(amount: $amount));
    }

    /**
     * @return array{
     *    0: array{0: 1.00, 1: 100.00},
     *    1: array{0: 1.15, 1: 115.00},
     *    2: array{0: 116.80, 1: 11680.00},
     *    3: array{0: .00, 1: 0}
     * }
     */
    public static function dataProviderConvert(): array
    {
        return [
            [
                1.00,
                100.00,
            ],
            [
                1.15,
                115.00,
            ],
            [
                116.80,
                11680.00,
            ],
            [
                .00,
                0,
            ],
        ];
    }
}
