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

        $vat = new Vat();
        $vat->setVat(19);

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
        $firstTestCase = new Price();
        $firstTestCase->setPrice(1200); // 12,00 €
        $expectedFirstGrossPrice = new Price();
        $expectedFirstGrossPrice->setPrice(1428); // 14,28 €

        $secondTestCase = new Price();
        $secondTestCase->setPrice(10599); // 105,99 €
        $expectedSecondGrossPrice = new Price();
        $expectedSecondGrossPrice->setPrice(12613); // 126,13 €

        return [
            [
                $firstTestCase,
                $expectedFirstGrossPrice,
            ],
            [
                $secondTestCase,
                $expectedSecondGrossPrice,
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
        $firstGrossPrice = new Price();
        $firstGrossPrice->setPrice(1428); // 14,28 €
        $salesTaxFromFirstGrossPrice = new Price();
        $salesTaxFromFirstGrossPrice->setPrice(228);

        $secondGrossPrice = new Price();
        $secondGrossPrice->setPrice(12613); // 126,13 €
        $salesTaxFromSecondGrossPrice = new Price();
        $salesTaxFromSecondGrossPrice->setPrice(2014);

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
        $firstTestCase = new Price();
        $firstTestCase->setPrice(1428); // 14,28 €
        $expectedFirstNetPrice = new Price();
        $expectedFirstNetPrice->setPrice(1200); // 12,00 €

        $secondTestCase = new Price();
        $secondTestCase->setPrice(12613); // 126,13 €
        $expectedSecondNetPrice = new Price();
        $expectedSecondNetPrice->setPrice(10599); // 105,99 €

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
