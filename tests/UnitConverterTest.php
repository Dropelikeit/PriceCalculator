<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests;

use MarcelStrahl\PriceCalculator\Contracts\Converter\ConverterInterface;
use MarcelStrahl\PriceCalculator\Contracts\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Contracts\UnitConverterInterface;
use MarcelStrahl\PriceCalculator\Factory\Converter;
use MarcelStrahl\PriceCalculator\UnitConverter;
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
        $unitConverter = new UnitConverter(factory: new Converter());

        $this->assertInstanceOf(expected: UnitConverterInterface::class, actual: $unitConverter);
        $this->assertInstanceOf(expected: UnitConverter::class, actual: $unitConverter);
    }

    #[Test]
    public function canConvert(): void
    {
        $unitConverter = new UnitConverter(new Converter());

        $converter = $unitConverter->convert(destinationUnit: ConverterFactoryInterface::EURO_TO_CENT);
        $this->assertInstanceOf(expected: ConverterInterface::class, actual: $converter);

        $converter = $unitConverter->convert(destinationUnit: ConverterFactoryInterface::CENT_TO_EURO);
        $this->assertInstanceOf(expected: ConverterInterface::class, actual: $converter);
    }
}
