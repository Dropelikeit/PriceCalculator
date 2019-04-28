<?php

namespace MarcelStrahl\PriceCalculator\Tests;

use MarcelStrahl\PriceCalculator\Factory\Converter;
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\UnitConverter;
use MarcelStrahl\PriceCalculator\UnitConverterInterface;
use PHPUnit\Framework\TestCase;

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
        $unitConverter = new UnitConverter(new Converter());

        $converter = $unitConverter->convert(ConverterFactoryInterface::EURO_TO_CENT);
        $this->assertInstanceOf(ConverterInterface::class, $converter);

        $converter = $unitConverter->convert(ConverterFactoryInterface::CENT_TO_EURO);
        $this->assertInstanceOf(ConverterInterface::class, $converter);
    }
}
