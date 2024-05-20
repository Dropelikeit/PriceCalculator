<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Contracts\Type\VatInterface;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: Vat::class)]
final class VatTest extends TestCase
{
    #[Test]
    public function canCreateVat(): void
    {
        $vat = Vat::create(0);
        $this->assertInstanceOf(VatInterface::class, $vat);
        $this->assertInstanceOf(Vat::class, $vat);

        $this->assertSame(0, $vat->getVat());
    }

    #[Test]
    public function canCreateVatAndGetRightValue(): void
    {
        $vat = Vat::create(19);
        $this->assertSame(19, $vat->getVat());
    }
}
