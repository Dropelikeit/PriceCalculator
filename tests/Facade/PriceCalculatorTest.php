<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Facade;

use MarcelStrahl\PriceCalculator\Contracts\PriceCalculatorInterface;
use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: PriceCalculatorFacade::class)]
final class PriceCalculatorTest extends TestCase
{
    #[Test]
    public function canInitPriceCalculatorFacade(): void
    {
        $facade = new PriceCalculatorFacade();
        $this->assertInstanceOf(PriceCalculatorFacade::class, $facade);
    }

    #[Test]
    public function canGetPriceCalculator(): void
    {
        $facade = new PriceCalculatorFacade();
        $priceCalculator = $facade::getPriceCalculator();

        $this->assertInstanceOf(PriceCalculatorInterface::class, $priceCalculator);
    }
}
