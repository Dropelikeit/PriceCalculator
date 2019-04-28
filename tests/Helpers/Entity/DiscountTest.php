<?php

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Types\DiscountInterface;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 * Class DiscountTest
 * @package MarcelStrahl\PriceCalculator\Tests\Helpers\Entity
 */
class DiscountTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderCreateDiscount
     * @param int $discount
     * @param int $expectedDiscount
     * @return void
     */
    public function canSetDiscount(int $discount, int $expectedDiscount): void
    {
        $discount = new Discount($discount);
        $this->assertInstanceOf(DiscountInterface::class, $discount);
        $this->assertSame($expectedDiscount, $discount->getDiscount());
    }

    public function dataProviderCreateDiscount(): array
    {
        return [
            'create_discount_successfully' => [
                100, 100,
            ],

        ];
    }

    /**
     * @test
     * @dataProvider dataProviderCannotCreateDiscount
     * @param mixed $discount
     * @param bool $expectedException
     */
    public function canNotSetDiscount($discount, bool $expectedException): void
    {
        if ($expectedException) {
            $this->expectException(TypeError::class);
        }

        new Discount($discount);
    }

    public function dataProviderCannotCreateDiscount(): array
    {
        return [
            'failed_by_string' => [
                'hello', true,
            ],
            'failed_by_object' => [
                new stdClass(), true,
            ],
        ];
    }
}
