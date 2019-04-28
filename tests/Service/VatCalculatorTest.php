<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class VatCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateVatCalculator(): void
    {
        $vatCalculator = new VatCalculator(new Vat(), new PriceCalculator());
        $this->assertInstanceOf(VatCalculator::class, $vatCalculator);
    }

    /**
     * @dataProvider dataProviderSalesTaxOfTotal
     * @param Price $grossPrice
     * @param Vat $vat
     * @param Price $netPrice
     * @param Price $expectedVat
     * @return void
     */
    public function testCanCalculateSalesTaxOfTotal(Price $grossPrice, Vat $vat, Price $netPrice, Price $expectedVat): void
    {
        $vatCalculator = new VatCalculator($vat, new PriceCalculator());
        $vatPrice = $vatCalculator->calculateSalesTaxFromTotalPrice($grossPrice);
        $this->assertSame($expectedVat->getPrice(), $vatPrice->getPrice());
        $this->assertSame($netPrice->getPrice(), $grossPrice->getPrice() - $vatPrice->getPrice());
        $this->assertSame($grossPrice->getPrice(), $netPrice->getPrice() + $vatPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderSalesTaxOfTotal(): array
    {
        $firstGrossPrice = new Price();
        $firstGrossPrice->setPrice(24);
        $vat = new Vat();
        $vat->setVat(19);
        $firstNetPrice = new Price();
        $firstNetPrice->setPrice(20);
        $expectedVatPrice = new Price();
        $expectedVatPrice->setPrice(4);

        $secondGrossPrice = new Price();
        $secondGrossPrice->setPrice(30000);
        $secondNetPrice = new Price();
        $secondNetPrice->setPrice(25210);
        $expectedSecondVatPrice = new Price();
        $expectedSecondVatPrice->setPrice(4790);

        $thirdGrossPrice = new Price();
        $thirdGrossPrice->setPrice(1500);
        $thirdNetPrice = new Price();
        $thirdNetPrice->setPrice(1261);
        $expectedThirdVatPrice = new Price();
        $expectedThirdVatPrice->setPrice(239);

        return [
            [
                $firstGrossPrice, $vat, $firstNetPrice, $expectedVatPrice,
            ],
            [
                $secondGrossPrice, $vat, $secondNetPrice, $expectedSecondVatPrice,
            ],
            [
                $thirdGrossPrice, $vat, $thirdNetPrice, $expectedThirdVatPrice,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderPriceWithSalesTax
     * @param Price $netPrice
     * @param Vat $vat
     * @param Price $expectedPrice
     * @return void
     */
    public function canCalculatePriceWithSalesTax(Price $netPrice, Vat $vat, Price $expectedPrice): void
    {
        $vatCalculator = new VatCalculator($vat, new PriceCalculator());

        $calculatedPrice = $vatCalculator->calculatePriceWithSalesTax($netPrice);

        $this->assertSame($expectedPrice->getPrice(), $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderPriceWithSalesTax(): array
    {
        $lowPrice = new Price();
        $lowPrice->setPrice(3151);
        $vat = new Vat();
        $vat->setVat(19);
        $expectedLowPrice = new Price();
        $expectedLowPrice->setPrice(3750);

        $secondPrice = new Price();
        $secondPrice->setPrice(25200);
        $expectedSecondPrice = new Price();
        $expectedSecondPrice->setPrice(29988);

        $thirdPrice = new Price();
        $thirdPrice->setPrice(15);
        $expectedThirdPrice = new Price();
        $expectedThirdPrice->setPrice(18);

        return [
            [
                $lowPrice, $vat, $expectedLowPrice,
            ],
            [
                $secondPrice, $vat, $expectedSecondPrice,
            ],
            [
                $thirdPrice, $vat, $expectedThirdPrice,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderCalculateNetPriceFromGrossPrice
     * @param Price $grossPrice
     * @param Vat $vat
     * @param Price $expectedNetPrice
     * @return void
     */
    public function canCalculateNetPriceFromGrossPrice(Price $grossPrice, Vat $vat, Price $expectedNetPrice): void
    {
        $vatCalculator = new VatCalculator($vat, new PriceCalculator());
        $netPrice = $vatCalculator->calculateNetPriceFromGrossPrice($grossPrice);

        $this->assertSame($expectedNetPrice->getPrice(), $netPrice->getPrice());
    }

    /**
     * @return array
     */
    public function dataProviderCalculateNetPriceFromGrossPrice(): array
    {
        $lowPrice = new Price();
        $lowPrice->setPrice(3750);
        $vat = new Vat();
        $vat->setVat(19);
        $expectedLowPrice = new Price();
        $expectedLowPrice->setPrice(3151);

        $secondPrice = new Price();
        $secondPrice->setPrice(29988);
        $expectedSecondPrice = new Price();
        $expectedSecondPrice->setPrice(25200);

        $thirdPrice = new Price();
        $thirdPrice->setPrice(18);
        $expectedThirdPrice = new Price();
        $expectedThirdPrice->setPrice(15);

        return [
            [
                $lowPrice, $vat, $expectedLowPrice,
            ],
            [
                $secondPrice, $vat, $expectedSecondPrice,
            ],
            [
                $thirdPrice, $vat, $expectedThirdPrice,
            ],
        ];
    }
}
