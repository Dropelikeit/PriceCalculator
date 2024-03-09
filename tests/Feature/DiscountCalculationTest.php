<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Feature;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Service\DiscountCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class DiscountCalculationTest extends TestCase
{
    #[Test]
    #[DataProvider(methodName: 'dataProviderCanCalculateDiscountedTotal')]
    public function canCalculateDiscountedTotal(int $priceAmount, float $discountAmount, int $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $price = Price::create($priceAmount);

        $discount = new Discount($discountAmount);

        $total = $discountCalculator->calculateDiscountFromTotal($price, $discount);

        $this->assertEquals($expectedPrice, $total->getPrice());
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanCalculateDiscountPrice')]
    public function canCalculateDiscountPrice(int $priceAmount, float $discountAmount, int $expectedPrice): void
    {
        $discountCalculator = new DiscountCalculator();

        $price = Price::create($priceAmount);

        $discount = new Discount($discountAmount);

        $discountPrice = $discountCalculator->calculateDiscountPriceFromTotal($price, $discount);

        $this->assertEquals($expectedPrice, $discountPrice->getPrice());
    }

    /**
     * @return array{
     *     0: array{0: 1500, 1: 15, 2: 225},
     *     1: array{0: 2700, 1: 50, 2: 1350},
     *     2: array{0: 50000, 1: 99, 2: 49500},
     *     3: array{0: 500, 1: 18.31, 2: 92}
     * }
     */
    public static function dataProviderCanCalculateDiscountPrice(): array
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

    /**
     * @return array{
     *     0: array{0: 1500, 1: 15, 2: 1275},
     *     1: array{0: 2700, 1: 50, 2: 1350},
     *     2: array{0: 50000, 1: 99, 2: 500},
     *     3: array{0: 500, 1: 18.31, 2: 408}
     * }
     */
    public static function dataProviderCanCalculateDiscountedTotal(): array
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
