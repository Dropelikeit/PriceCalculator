<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Service\DiscountCalculator;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class DiscountCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderCalculateDiscountPriceFromTotal
     * @param Price $total
     * @param Discount $percent
     * @param Price $expectedPrice
     * @return void
     */
    public function canCalculateDiscountPriceFromTotal(Price $total, Discount $percent, Price $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $calculatedPrice = $discountCalculator->calculateDiscountPriceFromTotal($total, $percent);

        $this->assertSame($expectedPrice->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderCalculateDiscountPriceFromTotal(): array
    {
        $discount = new Discount(45);
        $totalPrice = new Price();
        $totalPrice->setPrice(100);
        $expectedDiscountPrice = new Price();
        $expectedDiscountPrice->setPrice(45);

        $totalPriceIsZero = new Price();
        $totalPriceIsZero->setPrice(0);
        $expectedDiscountPriceIsZero = new Price();
        $expectedDiscountPriceIsZero->setPrice(0);

        return [
            'can_calculate_discount' => [
                $totalPrice, $discount, $expectedDiscountPrice,
            ],
            'can_handle_if_price_is_zero' => [
                $totalPriceIsZero, $discount, $expectedDiscountPriceIsZero,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderCalculateDiscountFromTotal
     * @param Price $total
     * @param Discount $percent
     * @param Price $expectedPrice
     * @return void
     */
    public function canCalculateDiscountFromTotal(Price $total, Discount $percent, Price $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $calculatedPrice = $discountCalculator->calculateDiscountFromTotal($total, $percent);

        $this->assertSame($expectedPrice->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderCalculateDiscountFromTotal(): array
    {
        $discount = new Discount(45);
        $totalPrice = new Price();
        $totalPrice->setPrice(100);
        $expectedDiscountPrice = new Price();
        $expectedDiscountPrice->setPrice(55);

        $discountForZeroTotalPrice = new Discount(30);
        $totalPriceForZeroTotalPrice = new Price();
        $totalPriceForZeroTotalPrice->setPrice(0);
        $expectedDiscountPriceForZeroTest = new Price();
        $expectedDiscountPriceForZeroTest->setPrice(0);

        return [
            'can_calculate_total_price_after_discount' => [
                $totalPrice, $discount, $expectedDiscountPrice,
            ],
            'can_handle_zero_total_price_without_error' => [
                $totalPriceForZeroTotalPrice, $discountForZeroTotalPrice, $expectedDiscountPriceForZeroTest,
            ],
        ];
    }
}
