<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Facade;

use MarcelStrahl\PriceCalculator\Facade\PriceCalculator;
use MarcelStrahl\PriceCalculator\Facade\VatCalculator as VatCalculatorFacade;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: VatCalculatorFacade::class)]
#[UsesClass(className: VatCalculator::class)]
#[UsesClass(className: Vat::class)]
#[UsesClass(className: PriceCalculator::class)]
final class VatCalculatorTest extends TestCase
{
    #[Test]
    public function canInitVatCalculatorFacade(): void
    {
        $vatCalculator = VatCalculatorFacade::getVatCalculator(19);

        $this->assertInstanceOf(
            VatCalculator::class,
            $vatCalculator
        );
    }
}
