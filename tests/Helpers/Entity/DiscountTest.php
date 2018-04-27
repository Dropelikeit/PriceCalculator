<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Types\DiscountInterface;
use MarcelStrahl\PriceCalculator\Helpers\Types\NumberInterface;
use MarcelStrahl\PriceCalculator\Helpers\Types\PercentInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 * Class DiscountTest
 * @package MarcelStrahl\PriceCalculator\Tests\Helpers\Entity
 */
class DiscountTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanSetDiscount(): void
    {
        $discount = new Discount($percent = 0.5);
        $this->assertInstanceOf(DiscountInterface::class, $discount);
        $this->assertInstanceOf(PercentInterface::class, $discount);
        $this->assertSame($percent, $discount->getDiscount());
    }
}
