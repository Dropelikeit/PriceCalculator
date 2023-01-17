<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Helpers\Types\VatInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class VatTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateVat(): void
    {
        $vat = Vat::create(0);
        $this->assertInstanceOf(VatInterface::class, $vat);
        $this->assertInstanceOf(Vat::class, $vat);

        $this->assertSame(0, $vat->getVat());
    }

    /**
     * @test
     */
    public function canCreateVatAndGetRightValue(): void
    {
        $vat = Vat::create(19);
        $this->assertSame(19, $vat->getVat());
    }
}
