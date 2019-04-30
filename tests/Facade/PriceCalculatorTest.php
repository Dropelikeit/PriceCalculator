<?php

namespace MarcelStrahl\PriceCalculator\Tests\Facade;

use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class PriceCalculatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanInitPriceCalculatorFacade(): void
    {
        $facade = new PriceCalculatorFacade();
        $this->assertInstanceOf(PriceCalculatorFacade::class, $facade);
    }

    /**
     * @return void
     */
    public function testGetPriceCalculator(): void
    {
        $facade = new PriceCalculatorFacade();
        $priceCalculator = $facade::getPriceCalculator();

        $this->assertInstanceOf(PriceCalculatorInterface::class, $priceCalculator);
    }
}
