<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Helpers\Types\PercentInterface;
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
     * @return void
     */
    public function testImplements(): void
    {
        $vat = new Vat();
        $this->assertInstanceOf(VatInterface::class, $vat);
        $this->assertInstanceOf(Vat::class, $vat);
        $this->assertInstanceOf(PercentInterface::class, $vat);
    }

    /**
     * @return void
     */
    public function testGetter(): void
    {
        $vat = new Vat();
        $vat->setVat($testVat = 19.00);
        $this->assertSame($testVat, $vat->getVat());
        $this->assertSame(1.19, $vat->getVatToCalculate());
    }
}
