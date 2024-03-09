<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests;

use MarcelStrahl\PriceCalculator\Factory\Converter;
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\UnitConverter;
use MarcelStrahl\PriceCalculator\UnitConverterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: UnitConverter::class)]
#[UsesClass(className: Converter::class)]
final class UnitConverterTest extends TestCase
{
    #[Test]
    public function hasImplemented(): void
    {
        $unitConverter = new UnitConverter(new Converter());
        $this->assertInstanceOf(UnitConverterInterface::class, $unitConverter);
        $this->assertInstanceOf(UnitConverter::class, $unitConverter);
    }

    #[Test]
    public function canConvert(): void
    {
        $unitConverter = new UnitConverter(new Converter());

        $converter = $unitConverter->convert(ConverterFactoryInterface::EURO_TO_CENT);
        $this->assertInstanceOf(ConverterInterface::class, $converter);

        $converter = $unitConverter->convert(ConverterFactoryInterface::CENT_TO_EURO);
        $this->assertInstanceOf(ConverterInterface::class, $converter);
    }
}
