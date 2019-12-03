<?php

namespace MarcelStrahl\PriceCalculator\Tests\Facade;

use MarcelStrahl\PriceCalculator\Facade\VatCalculator as VatCalculatorFacade;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanInitVatCalculatorFacade(): void
    {
        $vatCalculator = VatCalculatorFacade::getVatCalculator(19);

        $this->assertInstanceOf(
            VatCalculator::class,
            $vatCalculator
        );
    }
}
