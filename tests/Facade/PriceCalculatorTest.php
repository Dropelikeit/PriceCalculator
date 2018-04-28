<?php

namespace MarcelStrahl\PriceCalculator\Tests\Facade;

use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class PriceCalculatorTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Tests\Facade
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
    public function testGetPriceCalculaltor(): void
    {
        $facade = new PriceCalculatorFacade();
        $priceCalculator = $facade::getPriceCalculator(19);

        $this->assertInstanceOf(PriceCalculatorInterface::class, $priceCalculator);
    }
}
