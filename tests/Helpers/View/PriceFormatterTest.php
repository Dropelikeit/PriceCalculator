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
