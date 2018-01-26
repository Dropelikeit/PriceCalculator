<?php

namespace MarcelStrahl\PriceCalculator\Tests;

use MarcelStrahl\PriceCalculator\Factory\Converter;
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\UnitConverterInterface;
use PHPUnit\Framework\TestCase;
use MarcelStrahl\PriceCalculator\UnitConverter;

/**
 * Class UnitConverterTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Tests
 */
class UnitConverterTest extends TestCase
{
    /**
     * @return void
     */
    public function testImplements(): void
    {
        $unitConverter = new UnitConverter(new Converter());
        $this->assertInstanceOf(UnitConverterInterface::class, $unitConverter);
        $this->assertInstanceOf(UnitConverter::class, $unitConverter);
    }

    /**
     * @return void
     */
    public function testConvert(): void
    {
        $unitConveter = new UnitConverter(new Converter());

        $converter = $unitConveter->convert(ConverterFactoryInterface::EURO_TO_CENT);
        $this->assertInstanceOf(ConverterInterface::class, $converter);

        $converter = $unitConveter->convert(ConverterFactoryInterface::CENT_TO_EURO);
        $this->assertInstanceOf(ConverterInterface::class, $converter);
    }
}
