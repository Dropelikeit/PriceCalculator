<?php

namespace MarcelStrahl\PriceCalculator\Tests;

use MarcelStrahl\PriceCalculator\Factory\Converter;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use PHPUnit\Framework\TestCase;
use MarcelStrahl\PriceCalculator\PriceCalculator;

/**
 * Class PriceCalculatorTest
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package Tests
 */
class PriceCalculatorTest extends TestCase
{
    /**
     * @return PriceCalculator
     */
    private function getPriceCalculator(): PriceCalculator
    {

        return new PriceCalculator(new Vat());
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
     * @param float $price
     * @param float $amount
     * @param float $expected
     * @return void
     */
    public function testCanAdd(float $price, float $amount, float $expected): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $this->assertSame($expected, $priceCalculator->addPrice($price, $amount));
    }

    /**
     * @return array
     */
    public function dataProviderAddPrice(): array
    {
        return [
            [
                100, 200, 300
            ],
            [
                13, 2, 15
            ],
        ];
    }

    /**
     * @dataProvider dataProviderSubPrice
     * @param float $price
     * @param float $amount
     * @param float $total
     * @return void
     */
    public function testCanSub(float $price, float $amount, float $total): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $this->assertSame($total, $priceCalculator->subPrice($price, $amount));
    }

    /**
     * @return array
     */
    public function dataProviderSubPrice(): array
    {
        return [
            [
                300, 200, 100
            ],
            [
                15, 2, 13
            ],
        ];
    }

    /**
     * @dataProvider dataProviderMulPrice
     * @param int $price
     * @param int $amount
     * @param int $total
     * @return void
     */
    public function testCanMul(int $price, int $amount, int $total): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $this->assertEquals($total, $priceCalculator->mulPrice($amount, $price));
    }

    /**
     * @return array
     */
    public function dataProviderMulPrice(): array
    {
        return [
            [
                100, 5, 500
            ],
            [
                15, 2, 30
            ],
        ];
    }

    /**
     * @dataProvider dataProviderSalesTaxOfTotal
     * @param float $grossPrice
     * @param float $netPrice
     * @param float $expectedVat
     * @return void
     */
    public function testCanCalculateSalesTaxOfTotal(float $grossPrice, float $netPrice, float $expectedVat): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $priceCalculator->setVat(19);
        $vatPrice = $priceCalculator->calculateSalesTaxFromTotalPrice($grossPrice);
        $this->assertSame($expectedVat, $vatPrice);
        $this->assertSame($netPrice, (float)bcsub($grossPrice, $vatPrice));
        $this->assertSame($grossPrice, (float)bcadd($netPrice, $vatPrice));
    }

    /**
     * @return array
     */
    public function dataProviderSalesTaxOfTotal(): array
    {
        return [
            [
                300, 252, 48,
            ],
            [
                76160, 64000, 12160
            ],
            [
                405, 340, 65
            ],
            [
                15, 13, 2
            ],
            [
                238, 200, 38
            ]
        ];
    }

    /**
     * @dataProvider dataProviderPriceWithSalesTax
     * @param float $netPrice
     * @param float $expectedPrice
     * @return void
     */
    public function testCanCalculatePriceWithSalesTax(float $netPrice, float $expectedPrice): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $priceCalculator->setVat(19);
        $total = $priceCalculator->calculatePriceWithSalesTax($netPrice);
        $this->assertSame($expectedPrice, $total);
    }

    /**
     * @return array
     */
    public function dataProviderPriceWithSalesTax(): array
    {
        return [
            [
                252, 300
            ],
            [
                340, 405
            ],
            [
                200, 238
            ],
            [
                13, 15
            ],
            [
                64000, 76160
            ]
        ];
    }

    /**
     * @dataProvider dataProviderCalculateNetPriceFromGrossPrice
     * @param float $grossPrice
     * @param float $expectedNetPrice
     * @return void
     */
    public function testCanCalculateNetPriceFromGrossPrice(float $grossPrice, float $expectedNetPrice): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $priceCalculator->setVat(19);
        $netPrice = $priceCalculator->calculateNetPriceFromGrossPrice($grossPrice);

        $this->assertSame($expectedNetPrice, $netPrice);
    }

    /**
     * @return array
     */
    public function dataProviderCalculateNetPriceFromGrossPrice(): array
    {
        return [
            [
                300, 252,
            ],
            [
                405, 340,
            ],
            [
                238, 200,
            ],
            [
                15, 13,
            ],
            [
                76160, 64000,
            ],
        ];
    }
}
