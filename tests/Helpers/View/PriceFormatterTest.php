<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\View;

use MarcelStrahl\PriceCalculator\Helpers\View\Formatter;
use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class PriceFormatterTest extends TestCase
{
    /**
     * @return void
     */
    public function testInitPriceFormatter(): void
    {
        $priceFormatter = $this->getPriceFormatter(0, '', '', '€');
        $this->assertInstanceOf(PriceFormatter::class, $priceFormatter);
        $this->assertInstanceOf(Formatter::class, $priceFormatter);
    }

    /**
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     * @param string $currency
     * @return PriceFormatter
     */
    private function getPriceFormatter(
        int $decimals,
        string $decPoint,
        string $thousandsSep,
        string $currency
    ): PriceFormatter {
        return new PriceFormatter($decimals, $decPoint, $thousandsSep, $currency);
    }

    /**
     * @dataProvider dataProviderFormatPriceForView
     * @param float $price
     * @param string $expected
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     * @param string $currency
     * @return void
     */
    public function testCanFormatPriceForView(
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

    /**
     * @dataProvider dataProviderFormatPriceWithNoDefaults
     * @param float $price
     * @param string $expected
     * @param int $decimals
     * @param string $decSep
     * @param string $thousandsSep
     * @param string $currency
     * @return void
     */
    public function testCanFormatPrice(
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
     * @return array
     */
    public function dataProviderFormatPriceWithNoDefaults(): array
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
     * @return array
     */
    public function dataProviderFormatPriceForView(): array
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
