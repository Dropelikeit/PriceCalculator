<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\EuroToCent;
use PHPUnit\Framework\TestCase;

/**
 * Class EuroToCentTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Tests\Helpers\Converter
 */
class EuroToCentTest extends TestCase
{
    /**
     * @return void
     */
    public function testImplements(): void
    {
        $converter = new EuroToCent();
        $this->assertInstanceOf(ConverterInterface::class, $converter);
        $this->assertInstanceOf(EuroToCent::class, $converter);
    }

    /**
     * @dataProvider dataProviderConvert
     * @param float $amount
     * @param float $expected
     * @return void
     */
    public function testConvert(float $amount, float $expected): void
    {
        $converter = new EuroToCent();
        $this->assertSame($expected, $converter->convert($amount));
    }

    /**
     * @return array
     */
    public function dataProviderConvert(): array
    {
        return [
            [1.00, 100.00],
            [1.15, 115.00],
            [116.80, 11680.00],
        ];
    }
}
