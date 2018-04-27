<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Converter\Currencies;

use MarcelStrahl\PriceCalculator\Exceptions\ConverterException;
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
        $converter = new CentToEuro();
        $this->assertInstanceOf(ConverterInterface::class, $converter);
        $this->assertInstanceOf(CentToEuro::class, $converter);
    }

    /**
     * @dataProvider dataProviderConvert
     * @param null|float $amount
     * @param null|float $expected
     * @return void
     * @throws ConverterException
     */
    public function testConvert(float $amount, float $expected): void
    {
        $converter = new CentToEuro();

        if ($amount === .00) {
            $this->expectException(ConverterException::class);
        }

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
            [.00, .00],
        ];
    }
}
