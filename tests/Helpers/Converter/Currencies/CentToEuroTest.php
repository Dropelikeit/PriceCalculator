<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class CentToEuroTest extends TestCase
{
    /**
     * @return void
     */
    public function testImplements(): void
    {
        $converter = new CentToEuro();
        $this->assertInstanceOf(ConverterInterface::class, $converter);
        $this->assertInstanceOf(CentToEuro::class, $converter);
    }

    /**
     * @dataProvider dataProviderConvert
     */
    public function testConvert(float $amount, float $expected): void
    {
        $converter = new CentToEuro();

        $this->assertSame($expected, $converter->convert($amount));
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
            [.00, 0],
        ];
    }
}
