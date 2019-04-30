<?php

declare(strict_types=1);

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
        $this->assertInstanceOf(
            VatCalculator::class,
            VatCalculatorFacade::getVatCalculator(19)
        );
    }
}
