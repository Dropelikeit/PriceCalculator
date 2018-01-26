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
     * @param int $price
     * @param int $amount
     * @param int $expected
     * @return void
     */
    public function testCanAdd(int $price, int $amount, int $expected): void
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
     * @param int $price
     * @param int $amount
     * @param int $total
     * @return void
     */
    public function testCanSub(int $price, int $amount, int $total): void
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
     * @param int $grossPrice
     * @param int $netPrice
     * @param int $expectedVat
     * @return void
     */
    public function testCanCalculateSalesTaxOfTotal(int $grossPrice, int $netPrice, int $expectedVat): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $priceCalculator->setVat(19);
        $vatPrice = $priceCalculator->calculateSalesTaxFromTotalPrice($grossPrice);
        $this->assertSame($expectedVat, $vatPrice);
        $this->assertSame($netPrice, (int)bcsub($grossPrice, $vatPrice));
        $this->assertSame($grossPrice, (int)bcadd($netPrice, $vatPrice));
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
     * @param int $netPrice
     * @param int $expectedPrice
     */
    public function testCanCalculatePriceWithSalesTax(int $netPrice, int $expectedPrice): void
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
     * @param int $grossPrice
     * @param int $expectedNetPrice
     */
    public function testCanCalculateNetPriceFromGrossPrice(int $grossPrice, int $expectedNetPrice): void
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
