<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class PriceCalculatorTest extends TestCase
{
    /**
     * @return PriceCalculator
     */
    private function getPriceCalculator(): PriceCalculator
    {
        return new PriceCalculator();
    }

    /**
     * @return void
     */
    public function testCanInitPriceCalculator(): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $this->assertInstanceOf(PriceCalculator::class, $priceCalculator);
        $this->assertInstanceOf(PriceCalculatorInterface::class, $priceCalculator);
    }

    /**
     * @dataProvider dataProviderAddPrice
     * @param Price $price
     * @param Price $amount
     * @param Price $expected
     * @return void
     */
    public function testCanAdd(Price $price, Price $amount, Price $expected): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $calculatedPrice = $priceCalculator->addPrice($price, $amount);
        $this->assertSame($expected->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderAddPrice(): array
    {
        $price = Price::create(100);

        $amount = Price::create(200);

        $expectedPrice = Price::create(300);

        $priceUnderHundred = Price::create(13);

        $amountUnderHundred = Price::create(2);

        $expectedPriceUnderHundred = Price::create(15);

        return [
            'add_price_about_hundred' => [
                $price, $amount, $expectedPrice,
            ],
            'add_price_under_hundred' => [
                $priceUnderHundred, $amountUnderHundred, $expectedPriceUnderHundred,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderSubPrice
     * @param Price $price
     * @param Price $amount
     * @param Price $total
     * @return void
     */
    public function testCanSub(Price $price, Price $amount, Price $total): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $calculatedPrice = $priceCalculator->subPrice($price, $amount);

        $this->assertSame($total->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderSubPrice(): array
    {
        $price = Price::create(300);

        $amount = Price::create(200);

        $expectedPrice = Price::create(100);

        $priceUnderHundred = Price::create(15);

        $amountUnderHundred = Price::create(2);

        $expectedPriceUnderHundred = Price::create(13);

        $priceForZeroResult = Price::create(5);

        $amountForZeroResult = Price::create(6);

        $expectedPriceForZeroResult = Price::create(0);

        return [
            'sub_price_about_hundred' => [
                $price, $amount, $expectedPrice,
            ],
            'sub_price_under_hundred' => [
                $priceUnderHundred, $amountUnderHundred, $expectedPriceUnderHundred,
            ],
            'sub_price_and_calculate_zero_price' => [
                $priceForZeroResult, $amountForZeroResult, $expectedPriceForZeroResult,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderMulPrice
     * @param Price $price
     * @param Price $amount
     * @param Price $total
     * @return void
     */
    public function testCanMul(Price $price, Price $amount, Price $total): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $calculatedPrice = $priceCalculator->mulPrice($amount, $price);

        $this->assertEquals($total->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderMulPrice(): array
    {
        $priceWithBigNumber = Price::create(100);

        $amountForMulWithBigNumber = Price::create(5);

        $expectedPriceWithBigNumber = Price::create(500);

        $priceWithLowNumbers = Price::create(15);

        $amountForMulWithLowNumbers = Price::create(2);

        $expectedPriceWithLowNumbers = Price::create(30);

        return [
            'mul_with_big_numbers' => [
                $priceWithBigNumber, $amountForMulWithBigNumber, $expectedPriceWithBigNumber,
            ],
            'mul_with_low_numbers' => [
                $priceWithLowNumbers, $amountForMulWithLowNumbers, $expectedPriceWithLowNumbers,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderDivPrice
     * @param Price $price
     * @param int $amount
     * @param Price $total
     */
    public function canDiv(Price $price, int $amount, Price $total): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $calculatedPrice = $priceCalculator->divPrice($amount, $price);

        $this->assertEquals($total->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderDivPrice(): array
    {
        $priceWithBigNumber = Price::create(500);

        $amountForMulWithBigNumber = 5;
        $expectedPriceWithBigNumber = Price::create(100);

        $priceWithLowNumbers = Price::create(30);

        $amountForMulWithLowNumbers = 2;
        $expectedPriceWithLowNumbers = Price::create(15);

        $priceForZeroResult = Price::create(0);

        $amountForZeroResult = 6;
        $expectedPriceForZeroResult = Price::create(0);

        return [
            'div_with_big_numbers' => [
                $priceWithBigNumber, $amountForMulWithBigNumber, $expectedPriceWithBigNumber,
            ],
            'div_with_low_numbers' => [
                $priceWithLowNumbers, $amountForMulWithLowNumbers, $expectedPriceWithLowNumbers,
            ],
            'sub_price_and_calculate_zero_price' => [
                $priceForZeroResult, $amountForZeroResult, $expectedPriceForZeroResult,
            ],
        ];
    }
}
