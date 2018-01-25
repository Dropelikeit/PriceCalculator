<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Converter;

use MarcelStrahl\PriceCalculator\Helpers\Converter\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class CentToEuroTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Tests\Helpers\Converter
 */
class CentToEuroTest extends TestCase
{
    /**
     * @return void
     */
    public function testImplements(): void
    {
        $converter = new CentToEuro(1.00);
        $this->assertInstanceOf(ConverterInterface::class, $converter);
        $this->assertInstanceOf(CentToEuro::class, $converter);
    }

    /**
     * @dataProvider dataProviderConvert
     * @param float $amount
     * @param float $expected
     * @return void
     */
    public function testConvert(float $amount, float $expected): void
    {
        $converter = new CentToEuro($amount);
        $this->assertSame($expected, $converter->convert());
    }

    /**
     * @return array
     */
    public function dataProviderConvert(): array
    {
        return [
            [100.00, 1.00],
            [250.00, 2.50],
            [178, 1.78],
        ];
    }
}
