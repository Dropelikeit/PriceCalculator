<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\View;

use PHPUnit\Framework\TestCase;
use MarcelStrahl\PriceCalculator\Helpers\View\Formatter;
use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;

/**
 * Class PriceFormatterTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package Tests\Helpers\View
 */
class PriceFormatterTest extends TestCase
{
    /**
     * @return void
     */
    public function testInitPriceFormatter(): void
    {
        $priceFormatter = $this->getPriceFormatter();
        $this->assertInstanceOf(PriceFormatter::class, $priceFormatter);
        $this->assertInstanceOf(Formatter::class, $priceFormatter);
    }

    /**
     * @return PriceFormatter
     */
    private function getPriceFormatter(): PriceFormatter
    {
        return new PriceFormatter();
    }

    /**
     * @dataProvider dataProviderFormatPriceForView
     * @param float $price
     * @param string $expected
     * @return void
     */
    public function testCanFormatPriceForView(float $price, string $expected): void
    {
        $this->assertSame($expected, $this->getPriceFormatter()->formatPrice($price));
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
    public function testCanFormatPriceWithNoDefaults(
        float $price,
        string $expected,
        int $decimals,
        string $decSep,
        string $thousandsSep,
        string $currency
    ): void {
        $this->assertSame(
            $expected,
            $this->getPriceFormatter()->formatPrice($price, $decimals, $decSep, $thousandsSep, $currency)
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
                1.15, '1,15 €',
            ],
            [
                4.05, '4,05 €',
            ],
            [
                .15, '0,15 €',
            ],
            [
                761.60, '761,60 €',
            ],
        ];
    }

    /**
     * @expectedException \TypeError
     */
    public function testThrowExceptionByNonNumeric(): void
    {
        $priceFormatter = $this->getPriceFormatter();
        $priceFormatter->formatPrice('Hello World');
    }
}
