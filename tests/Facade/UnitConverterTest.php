<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Facade;

use MarcelStrahl\PriceCalculator\Contracts\UnitConverterInterface;
use MarcelStrahl\PriceCalculator\Facade\UnitConverter as UnitConverterFacade;
use MarcelStrahl\PriceCalculator\UnitConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: UnitConverterFacade::class)]
#[UsesClass(className: UnitConverter::class)]
final class UnitConverterTest extends TestCase
{
    #[Test]
    public function canInitPriceCalculatorFacade(): void
    {
        $facade = new UnitConverterFacade();
        $this->assertInstanceOf(UnitConverterFacade::class, $facade);
    }

    #[Test]
    public function canGetUnitConverter(): void
    {
        $facade = new UnitConverterFacade();
        $unitConverter = $facade::getConverter();

        $this->assertInstanceOf(UnitConverterInterface::class, $unitConverter);
    }
}
