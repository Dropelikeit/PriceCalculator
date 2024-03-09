<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Service\DiscountCalculator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: DiscountCalculator::class)]
#[UsesClass(className: Price::class)]
#[UsesClass(className: Discount::class)]
final class DiscountCalculatorTest extends TestCase
{
    #[Test]
    #[DataProvider(methodName: 'dataProviderCalculateDiscountPriceFromTotal')]
    public function canCalculateDiscountPriceFromTotal(Price $total, Discount $percent, Price $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $calculatedPrice = $discountCalculator->calculateDiscountPriceFromTotal($total, $percent);

        $this->assertSame($expectedPrice->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array{
     *     can_calculate_discount: array<int, Discount|Price>,
     *     can_handle_if_price_is_zero: array<int, Discount|Price>
     * }
     */
    public static function dataProviderCalculateDiscountPriceFromTotal(): array
    {
        $discount = new Discount(45);
        $totalPrice = Price::create(100);

        $expectedDiscountPrice = Price::create(45);

        $totalPriceIsZero = Price::create(0);

        $expectedDiscountPriceIsZero = Price::create(0);

        return [
            'can_calculate_discount' => [
                $totalPrice, $discount, $expectedDiscountPrice,
            ],
            'can_handle_if_price_is_zero' => [
                $totalPriceIsZero, $discount, $expectedDiscountPriceIsZero,
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCalculateDiscountFromTotal')]
    public function canCalculateDiscountFromTotal(Price $total, Discount $percent, Price $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $calculatedPrice = $discountCalculator->calculateDiscountFromTotal($total, $percent);

        $this->assertSame($expectedPrice->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array{
     *   can_calculate_total_price_after_discount: array<int, Price|Discount>,
     *   can_handle_zero_total_price_without_error: array<int, Price|Discount>
     * }
     */
    public static function dataProviderCalculateDiscountFromTotal(): array
    {
        $discount = new Discount(45);
        $totalPrice = Price::create(100);

        $expectedDiscountPrice = Price::create(55);

        $discountForZeroTotalPrice = new Discount(30);
        $totalPriceForZeroTotalPrice = Price::create(0);

        $expectedDiscountPriceForZeroTest = Price::create(0);

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
