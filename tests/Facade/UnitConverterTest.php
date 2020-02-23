<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Facade;

use MarcelStrahl\PriceCalculator\Facade\UnitConverter as UnitConverterFacade;
use MarcelStrahl\PriceCalculator\UnitConverterInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class UnitConverterTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Tests\Facade
 */
class UnitConverterTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanInitPriceCalculatorFacade(): void
    {
        $facade = new UnitConverterFacade();
        $this->assertInstanceOf(UnitConverterFacade::class, $facade);
    }

    /**
     * @return void
     */
    public function testCanGetUnitConverter(): void
    {
        $facade = new UnitConverterFacade();
        $unitConverter = $facade::getConverter();

        $this->assertInstanceOf(UnitConverterInterface::class, $unitConverter);
    }
}
