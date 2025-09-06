<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests;

use MarcelStrahl\PriceCalculator\Contracts\PriceCalculatorInterface;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: PriceCalculator::class)]
#[UsesClass(className: Price::class)]
final class PriceCalculatorTest extends TestCase
{
    private function getPriceCalculator(): PriceCalculator
    {
        return new PriceCalculator();
    }

    #[Test]
    public function canInitPriceCalculator(): void
    {
        $priceCalculator = $this->getPriceCalculator();

        $this->assertInstanceOf(expected: PriceCalculator::class, actual: $priceCalculator);
        $this->assertInstanceOf(expected: PriceCalculatorInterface::class, actual: $priceCalculator);
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderAddPrice')]
    public function canAdd(Price $price, Price $amount, Price $expected): void
    {
        $calculatedPrice = $this->getPriceCalculator()->addPrice($price, $amount);

        $this->assertSame($expected->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array{
     *     add_price_about_hundred: array<int, Price>,
     *     add_price_under_hundred: array<int. Price>
     * }
     */
    public static function dataProviderAddPrice(): array
    {
        $price = Price::create(price: 100);

        $amount = Price::create(price: 200);

        $expectedPrice = Price::create(price: 300);

        $priceUnderHundred = Price::create(price: 13);

        $amountUnderHundred = Price::create(price: 2);

        $expectedPriceUnderHundred = Price::create(price: 15);

        return [
            'add_price_about_hundred' => [
                $price,
                $amount,
                $expectedPrice,
            ],
            'add_price_under_hundred' => [
                $priceUnderHundred,
                $amountUnderHundred,
                $expectedPriceUnderHundred,
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderSubPrice')]
    public function canSub(Price $price, Price $amount, Price $total): void
    {
        $calculatedPrice = $this->getPriceCalculator()->subPrice(total: $price, price: $amount);

        $this->assertSame(expected: $total->getPrice(), actual: $calculatedPrice->getPrice());
    }

    /**
     * @return array{
     *     sub_price_about_hundred: array<int, Price>,
     *     sub_price_under_hundred: array<int, Price>,
     *     sub_price_and_calculate_zero_price: array<int, Price>
     * }
     */
    public static function dataProviderSubPrice(): array
    {
        $price = Price::create(price: 300);

        $amount = Price::create(price: 200);

        $expectedPrice = Price::create(price: 100);

        $priceUnderHundred = Price::create(price: 15);

        $amountUnderHundred = Price::create(price: 2);

        $expectedPriceUnderHundred = Price::create(price: 13);

        $priceForZeroResult = Price::create(price: 5);

        $amountForZeroResult = Price::create(price: 6);

        $expectedPriceForZeroResult = Price::create(price: 0);

        return [
            'sub_price_about_hundred'            => [
                $price,
                $amount,
                $expectedPrice,
            ],
            'sub_price_under_hundred'            => [
                $priceUnderHundred,
                $amountUnderHundred,
                $expectedPriceUnderHundred,
            ],
            'sub_price_and_calculate_zero_price' => [
                $priceForZeroResult,
                $amountForZeroResult,
                $expectedPriceForZeroResult,
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderMulPrice')]
    public function canMul(Price $price, Price $amount, Price $total): void
    {
        $calculatedPrice = $this->getPriceCalculator()->mulPrice(amount: $amount, price: $price);

        $this->assertEquals(expected: $total->getPrice(), actual: $calculatedPrice->getPrice());
    }

    /**
     * @return array{
     *     mul_with_big_numbers: array<int<0,2>, Price>,
     *     mul_with_low_numbers: array<int<0,2>, Price>
     * }
     */
    public static function dataProviderMulPrice(): array
    {
        $priceWithBigNumber = Price::create(price: 100);

        $amountForMulWithBigNumber = Price::create(price: 5);

        $expectedPriceWithBigNumber = Price::create(price: 500);

        $priceWithLowNumbers = Price::create(price: 15);

        $amountForMulWithLowNumbers = Price::create(price: 2);

        $expectedPriceWithLowNumbers = Price::create(price: 30);

        return [
            'mul_with_big_numbers' => [
                $priceWithBigNumber,
                $amountForMulWithBigNumber,
                $expectedPriceWithBigNumber,
            ],
            'mul_with_low_numbers' => [
                $priceWithLowNumbers,
                $amountForMulWithLowNumbers,
                $expectedPriceWithLowNumbers,
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderDivPrice')]
    public function canDiv(Price $price, int $amount, Price $total): void
    {
        $calculatedPrice = $this->getPriceCalculator()->divPrice(amount: $amount, price: $price);

        $this->assertEquals(expected: $total->getPrice(), actual: $calculatedPrice->getPrice());
    }

    /**
     * @return array{
     *     div_with_big_numbers: list{Price, 5, Price},
     *     div_with_low_numbers: list{Price, 2, Price},
     *     sub_price_and_calculate_zero_price: list{Price, 6,Price}}
     */
    public static function dataProviderDivPrice(): array
    {
        $priceWithBigNumber = Price::create(price: 500);

        $amountForMulWithBigNumber = 5;
        $expectedPriceWithBigNumber = Price::create(price: 100);

        $priceWithLowNumbers = Price::create(price: 30);

        $amountForMulWithLowNumbers = 2;
        $expectedPriceWithLowNumbers = Price::create(price: 15);

        $priceForZeroResult = Price::create(price: 0);

        $amountForZeroResult = 6;
        $expectedPriceForZeroResult = Price::create(price: 0);

        return [
            'div_with_big_numbers'               => [
                $priceWithBigNumber,
                $amountForMulWithBigNumber,
                $expectedPriceWithBigNumber,
            ],
            'div_with_low_numbers'               => [
                $priceWithLowNumbers,
                $amountForMulWithLowNumbers,
                $expectedPriceWithLowNumbers,
            ],
            'sub_price_and_calculate_zero_price' => [
                $priceForZeroResult,
                $amountForZeroResult,
                $expectedPriceForZeroResult,
            ],
        ];
    }

    #[Test]
    public function subResultCannotHaveNegativeAmount(): void
    {
        $totalPrice = Price::create(price: 200);
        $sub = Price::create(price: 300);

        $calculatedPrice = $this->getPriceCalculator()->subPrice(total: $totalPrice, price: $sub);

        $this->assertSame(expected: 0, actual: $calculatedPrice->getPrice());
    }

    #[Test]
    public function subResultCannotHaveZeroAmount(): void
    {
        $totalPrice = Price::create(price: 200);
        $sub = Price::create(price: 200);

        $calculatedPrice = $this->getPriceCalculator()->subPrice(total: $totalPrice, price: $sub);

        $this->assertSame(expected: 0, actual: $calculatedPrice->getPrice());
    }

    #[Test]
    public function divResultCannotHaveZeroAmount(): void
    {
        $totalPrice = Price::create(price: 200);

        $calculatedPrice = $this->getPriceCalculator()->divPrice(amount: 0, price: $totalPrice);

        $this->assertSame(expected: 0, actual: $calculatedPrice->getPrice());
    }

    #[Test]
    public function divResultCannotHaveNegativeAmount(): void
    {
        $totalPrice = Price::create(price: 0);

        $calculatedPrice = $this->getPriceCalculator()->divPrice(amount: -200, price: $totalPrice);

        $this->assertSame(expected: 0, actual: $calculatedPrice->getPrice());
    }
}
