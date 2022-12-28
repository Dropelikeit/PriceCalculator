<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Helpers\Types\VatInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class VatTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Tests\Helpers\Entity
 */
class VatTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function canCreateVat(): void
    {
        $vat = new Vat();
        $this->assertInstanceOf(VatInterface::class, $vat);
        $this->assertInstanceOf(Vat::class, $vat);
    }

    /**
     * @test
     */
    public function canCreateVatAndGetRightValue(): void
    {
        $vat = new Vat();
        $vat->setVat($testVat = 19);
        $this->assertSame($testVat, $vat->getVat());
    }
}
