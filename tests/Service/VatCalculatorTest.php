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
        $vatCalculator = new VatCalculator(Vat::create(0), new PriceCalculator());
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
    public function testCanCalculateSalesTaxOfTotal(
        Price $grossPrice,
        Vat $vat,
        Price $netPrice,
        Price $expectedVat
    ): void {
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
        $firstGrossPrice = Price::create(24);

        $vat = Vat::create(19);
        $firstNetPrice = Price::create(20);

        $expectedVatPrice = Price::create(4);

        $secondGrossPrice = Price::create(30000);

        $secondNetPrice = Price::create(25210);

        $expectedSecondVatPrice = Price::create(4790);

        $thirdGrossPrice = Price::create(1500);

        $thirdNetPrice = Price::create(1261);

        $expectedThirdVatPrice = Price::create(239);

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
        $lowPrice = Price::create(3151);
        $vat = Vat::create(19);
        $expectedLowPrice = Price::create(3750);

        $secondPrice = Price::create(25200);

        $expectedSecondPrice = Price::create(29988);

        $thirdPrice = Price::create(15);

        $expectedThirdPrice = Price::create(18);

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
        $lowPrice = Price::create(3750);
        $vat = Vat::create(19);

        $expectedLowPrice = Price::create(3151);

        $secondPrice = Price::create(29988);

        $expectedSecondPrice = Price::create(25200);

        $thirdPrice = Price::create(18);

        $expectedThirdPrice = Price::create(15);

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
