<?php

namespace MarcelStrahl\PriceCalculator\Tests\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Factory\ConverterFactory;
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\EuroToCent;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ConverterFactoryTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Tests\Factory
 */
class ConverterFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testImplements(): void
    {
        $converterFactory = new ConverterFactory();
        $this->assertInstanceOf(ConverterFactoryInterface::class, $converterFactory);
        $this->assertInstanceOf(ConverterFactory::class, $converterFactory);
    }

    /**
     * @dataProvider dataProviderGetConverter
     * @param string $currentUnit
     * @param string $newUnit
     * @param string $expectedClass
     * @return void
     */
    public function testGetConverter(string $currentUnit, string $newUnit, string $expectedClass): void
    {
        $factory = new ConverterFactory();

        if ($currentUnit === '' || $newUnit === '') {
            $this->expectException(PriceCalculatorFactoryException::class);
        }
        $converter = $factory->get(1.00, $currentUnit, $newUnit);

        $this->assertInstanceOf(ConverterInterface::class, $converter);
        $this->assertInstanceOf($expectedClass, $converter);
    }

    /**
     * @return array
     */
    public function dataProviderGetConverter(): array
    {
        return [
            [PriceCalculatorInterface::EURO_CENT, PriceCalculatorInterface::EURO, CentToEuro::class],
            [PriceCalculatorInterface::EURO, PriceCalculatorInterface::EURO_CENT, EuroToCent::class],
            ['', '', ''],
            ['', PriceCalculatorInterface::EURO_CENT, ''],
            [PriceCalculatorInterface::EURO, '', ''],
        ];
    }
}
