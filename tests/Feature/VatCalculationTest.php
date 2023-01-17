<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Feature;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculationTest extends TestCase
{

    /**
     * @var VatCalculator
     */
    private VatCalculator $vatCalculator;

    public function setUp(): void
    {
        parent::setUp();

        $vat = Vat::create(19);

        $this->vatCalculator = new VatCalculator($vat, new PriceCalculator());
    }

    /**
     * @test
     * @dataProvider dataProviderCanCalculatePriceWithSalesTax
     * @param Price $netPrice
     * @param Price $expectedGrossPrice
     */
    public function canCalculatePriceWithSalesTax(Price $netPrice, Price $expectedGrossPrice): void
    {
        $grossPrice = $this->vatCalculator->calculatePriceWithSalesTax($netPrice);

        $this->assertEquals($expectedGrossPrice->getPrice(), $grossPrice->getPrice());
    }

    public function dataProviderCanCalculatePriceWithSalesTax(): array
    {
        $firstTestCase = Price::create(1200); // 12,00 €

        $expectedFirstGrossPrice = Price::create(1428); // 14,28 €

        $secondTestCase = Price::create(10599); // 105,99 €

        $expectedSecondGrossPrice = Price::create(12613); // 126,13 €

        $thirdTestCase = Price::create(411); // 4,11 €

        $expectedThirdGrossPrice = Price::create(489); // 4,89 €

        return [
            [
                $firstTestCase,
                $expectedFirstGrossPrice,
            ],
            [
                $secondTestCase,
                $expectedSecondGrossPrice,
            ],
            [
                $thirdTestCase,
                $expectedThirdGrossPrice,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderCanCalculateSalesTaxFromTotalPrice
     * @param Price $total
     * @param Price $expectedSalesTax
     */
    public function canCalculateSalesTaxFromTotalPrice(Price $total, Price $expectedSalesTax): void
    {
        $salesTax = $this->vatCalculator->calculateSalesTaxFromTotalPrice($total);

        $this->assertEquals($expectedSalesTax->getPrice(), $salesTax->getPrice());
    }

    public function dataProviderCanCalculateSalesTaxFromTotalPrice(): array
    {
        $firstGrossPrice = Price::create(1428); // 14,28 €

        $salesTaxFromFirstGrossPrice = Price::create(228); // 2,28 €

        $secondGrossPrice = Price::create(12613); // 126,13 €

        $salesTaxFromSecondGrossPrice = Price::create(2014); // 20,14 €

        return [
            [
                $firstGrossPrice,
                $salesTaxFromFirstGrossPrice,
            ],
            [
                $secondGrossPrice,
                $salesTaxFromSecondGrossPrice,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderCanCalculateNetPriceFromGrossPrice
     * @param Price $total
     * @param Price $expectedNetPrice
     */
    public function canCalculateNetPriceFromGrossPrice(Price $total, Price $expectedNetPrice): void
    {
       $netPrice = $this->vatCalculator->calculateNetPriceFromGrossPrice($total);

       $this->assertEquals($expectedNetPrice->getPrice(), $netPrice->getPrice());
    }

    public function dataProviderCanCalculateNetPriceFromGrossPrice(): array
    {
        $firstTestCase = Price::create(1428); // 14,28 €

        $expectedFirstNetPrice = Price::create(1200); // 12,00 €

        $secondTestCase = Price::create(12613); // 126,13 €

        $expectedSecondNetPrice = Price::create(10599); // 105,99 €

        return [
            [
                $firstTestCase,
                $expectedFirstNetPrice,
            ],
            [
                $secondTestCase,
                $expectedSecondNetPrice,
            ],
        ];
    }
}
