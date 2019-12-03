<?php

namespace MarcelStrahl\PriceCalculator\Tests\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Factory\Converter;
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\EuroToCent;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class ConverterFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testImplements(): void
    {
        $converterFactory = new Converter();
        $this->assertInstanceOf(ConverterFactoryInterface::class, $converterFactory);
        $this->assertInstanceOf(Converter::class, $converterFactory);
    }

    /**
     * @dataProvider dataProviderGetConverter
     * @param string $destinationUnit
     * @param string $expectedClass
     * @return void
     */
    public function testGetConverter(string $destinationUnit, string $expectedClass): void
    {
        $factory = new Converter();

        if ($destinationUnit === '') {
            $this->expectException(PriceCalculatorFactoryException::class);
        }
        $converter = $factory->factorize($destinationUnit);

        $this->assertInstanceOf(ConverterInterface::class, $converter);
        $this->assertInstanceOf($expectedClass, $converter);
    }

    /**
     * @return array
     */
    public function dataProviderGetConverter(): array
    {
        return [
            [ConverterFactoryInterface::CENT_TO_EURO, CentToEuro::class],
            [ConverterFactoryInterface::EURO_TO_CENT, EuroToCent::class],
            ['', ''],
        ];
    }
}
