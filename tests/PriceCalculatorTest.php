<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\PriceCalculator;

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
        return PriceCalculator::getInstance(19);
    }

    /**
     * @return void
     */
    public function testCanInitPriceCalculator(): void
    {
        $vat = 19;
        $vatMax = '1.19';
        $priceCalculator = $this->getPriceCalculator();
        $this->assertInstanceOf(PriceCalculator::class, $priceCalculator);
        $this->assertSame($vat, $priceCalculator->getVat());
        $this->assertSame($vatMax, $priceCalculator->getVatToCalculate());
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
     * @dataProvider dataProviderEuroToCent
     * @param float $price
     * @param int $expected
     * @return void
     */
    public function testCanCalculateEuroToCent(float $price, int $expected): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $this->assertSame($expected, $priceCalculator->calculateEuroToCent($price));
    }

    /**
     * @return array
     */
    public function dataProviderEuroToCent(): array
    {
        return [
            [
                1.15, 115,
            ],
            [
                2.38, 238,
            ],
            [
                4.05, 405,
            ],
            [
                761.60, 76160,
            ],
            [
                0.15, 15,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCentToEuro
     * @param int $price
     * @param string $expected
     * @return void
     */
    public function testCanCalculateCentToEuro(int $price, string $expected): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $this->assertSame($expected, $priceCalculator->calculateCentToEuro($price));
    }

    /**
     * @return array
     */
    public function dataProviderCentToEuro(): array
    {
        return [
            [
                115, '1.15'
            ],
            [
                76160, '761.60'
            ],
            [
                238, '2.38'
            ],
            [
                15, '0.15'
            ],
            [
                405, '4.05'
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
}