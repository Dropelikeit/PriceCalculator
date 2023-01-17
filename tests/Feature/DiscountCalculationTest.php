<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Feature;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Service\DiscountCalculator;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class DiscountCalculationTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderCanCalculateDiscountedTotal
     * @param int $priceAmount
     * @param float $discountAmount
     * @param int $expectedPrice
     */
    public function canCalculateDiscountedTotal(int $priceAmount, float $discountAmount, int $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $price = Price::create($priceAmount);

        $discount = new Discount($discountAmount);

        $total = $discountCalculator->calculateDiscountFromTotal($price, $discount);

        $this->assertEquals($expectedPrice, $total->getPrice());
    }

    /**
     * @test
     * @dataProvider dataProviderCanCalculateDiscountPrice
     * @param int $priceAmount
     * @param float $discountAmount
     * @param int $expectedPrice
     */
    public function canCalculateDiscountPrice(int $priceAmount, float $discountAmount, int $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $price = Price::create($priceAmount);

        $discount = new Discount($discountAmount);

        $discountPrice = $discountCalculator->calculateDiscountPriceFromTotal($price, $discount);

        $this->assertEquals($expectedPrice, $discountPrice->getPrice());
    }

    public function dataProviderCanCalculateDiscountPrice(): array
    {
        return [
            [
                1500,
                15,
                225,
            ],
            [
                2700,
                50,
                1350,
            ],
            [
                50000,
                99,
                49500,
            ],
            [
                500,
                18.31,
                92,
            ],
        ];
    }

    public function dataProviderCanCalculateDiscountedTotal(): array
    {
        return [
            [
                1500,
                15,
                1275,
            ],
            [
                2700,
                50,
                1350,
            ],
            [
                50000,
                99,
                500,
            ],
            [
                500,
                18.31,
                408,
            ],
        ];
    }
}
