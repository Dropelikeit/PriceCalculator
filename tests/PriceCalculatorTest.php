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
        $price = new Price();
        $price->setPrice(100);
        $amount = new Price();
        $amount->setPrice(200);
        $expectedPrice = new Price();
        $expectedPrice->setPrice(300);

        $priceUnderHundred = new Price();
        $priceUnderHundred->setPrice(13);
        $amountUnterHundred = new Price();
        $amountUnterHundred->setPrice(2);
        $expectedPriceUnderHundred = new Price();
        $expectedPriceUnderHundred->setPrice(15);

        return [
            'add_price_about_hundred' => [
                $price, $amount, $expectedPrice,
            ],
            'add_price_under_hundred' => [
                $priceUnderHundred, $amountUnterHundred, $expectedPriceUnderHundred,
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
        $price = new Price();
        $price->setPrice(300);
        $amount = new Price();
        $amount->setPrice(200);
        $expectedPrice = new Price();
        $expectedPrice->setPrice(100);

        $priceUnderHundred = new Price();
        $priceUnderHundred->setPrice(15);
        $amountUnderHundred = new Price();
        $amountUnderHundred->setPrice(2);
        $expectedPriceUnderHundred = new Price();
        $expectedPriceUnderHundred->setPrice(13);

        $priceForZeroResult = new Price();
        $priceForZeroResult->setPrice(5);
        $amountForZeroResult = new Price();
        $amountForZeroResult->setPrice(6);
        $expectedPriceForZeroResult = new Price();
        $expectedPriceForZeroResult->setPrice(0);

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
     * @param int $amount
     * @param Price $total
     * @return void
     */
    public function testCanMul(Price $price, int $amount, Price $total): void
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
        $priceWithBigNumber = new Price();
        $priceWithBigNumber->setPrice(100);
        $amountForMulWithBigNumber = 5;
        $expectedPriceWithBigNumber = new Price();
        $expectedPriceWithBigNumber->setPrice(500);

        $priceWithLowNumbers = new Price();
        $priceWithLowNumbers->setPrice(15);
        $amountForMulWithLowNumbers = 2;
        $expectedPriceWithLowNumbers = new Price();
        $expectedPriceWithLowNumbers->setPrice(30);

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
        $priceWithBigNumber = new Price();
        $priceWithBigNumber->setPrice(500);
        $amountForMulWithBigNumber = 5;
        $expectedPriceWithBigNumber = new Price();
        $expectedPriceWithBigNumber->setPrice(100);

        $priceWithLowNumbers = new Price();
        $priceWithLowNumbers->setPrice(30);
        $amountForMulWithLowNumbers = 2;
        $expectedPriceWithLowNumbers = new Price();
        $expectedPriceWithLowNumbers->setPrice(15);

        $priceForZeroResult = new Price();
        $priceForZeroResult->setPrice(0);
        $amountForZeroResult = 6;
        $expectedPriceForZeroResult = new Price();
        $expectedPriceForZeroResult->setPrice(0);

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
