<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\View;

use MarcelStrahl\PriceCalculator\Contracts\View\Formatter;
use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: PriceFormatter::class)]
final class PriceFormatterTest extends TestCase
{
    #[Test]
    public function canInitPriceFormatter(): void
    {
        $priceFormatter = $this->getPriceFormatter(0, '', '', '€');
        $this->assertInstanceOf(PriceFormatter::class, $priceFormatter);
        $this->assertInstanceOf(Formatter::class, $priceFormatter);
    }

    private function getPriceFormatter(
        int $decimals,
        string $decPoint,
        string $thousandsSep,
        string $currency
    ): PriceFormatter {
        return new PriceFormatter($decimals, $decPoint, $thousandsSep, $currency);
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderFormatPriceForView')]
    public function canFormatPriceForView(
        float $price,
        string $expected,
        int $decimals,
        string $decPoint,
        string $thousandsSep,
        string $currency
    ): void {
        $this->assertSame(
            $expected,
            $this->getPriceFormatter(
                $decimals,
                $decPoint,
                $thousandsSep,
                $currency
            )->formatPrice($price)
        );
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderFormatPriceWithNoDefaults')]
    public function canFormatPrice(
        float $price,
        string $expected,
        int $decimals,
        string $decSep,
        string $thousandsSep,
        string $currency
    ): void {
        $this->assertSame(
            $expected,
            $this->getPriceFormatter($decimals, $decSep, $thousandsSep, $currency)->formatPrice($price)
        );
    }

    /**
     * @return array{
     *     0: array<int, string|int>,
     *     1: array<int, string|int>,
     *     2: array<int, string|int>,
     *     3: array<int, string|int>
     * }
     */
    public static function dataProviderFormatPriceWithNoDefaults(): array
    {
        return [
            [
                1.15, '1 @', 0, '', '', '@',
            ],
            [
                1000.15, '1/000|15 $', 2, '|', '/', '$',
            ],
            [
                1000.15, '1000,1500 XX', 4, ',', '', 'XX',
            ],
            [
                1000, '1,000 US-$', 0, '', ',', 'US-$',
            ],
        ];
    }

    /**
     * @return array{
     *     0: array<int, int|string>,
     *     1: array<int, int|string>,
     *     2: array<int, int|string>,
     *     3: array<int, int|string>
     * }
     */
    public static function dataProviderFormatPriceForView(): array
    {
        return [
            [
                1.15, '1,15 €', 2, ',', '.', '€',
            ],
            [
                4.05, '4,05 €', 2, ',', '.', '€',
            ],
            [
                .15, '0,15 €', 2, ',', '.', '€',
            ],
            [
                761.60, '761,60 €', 2, ',', '.', '€',
            ],
        ];
    }
}
