<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: VatCalculator::class)]
#[UsesClass(className: Vat::class)]
#[UsesClass(className: Price::class)]
#[UsesClass(className: PriceCalculator::class)]
final class VatCalculatorTest extends TestCase
{
    #[Test]
    public function canCreateVatCalculator(): void
    {
        $vatCalculator = new VatCalculator(vat: Vat::create(vat: 0), priceCalculator: new PriceCalculator());

        $this->assertInstanceOf(expected: VatCalculator::class, actual: $vatCalculator);
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderSalesTaxOfTotal')]
    public function canCalculateSalesTaxOfTotal(
        Price $grossPrice,
        Vat $vat,
        Price $netPrice,
        Price $expectedVat
    ): void {
        $vatCalculator = new VatCalculator($vat, new PriceCalculator());
        $vatPrice = $vatCalculator->calculateSalesTaxFromTotalPrice($grossPrice);
        $this->assertSame(expected: $expectedVat->getPrice(), actual: $vatPrice->getPrice());
        $this->assertSame(expected: $netPrice->getPrice(), actual: $grossPrice->getPrice() - $vatPrice->getPrice());
        $this->assertSame(expected: $grossPrice->getPrice(), actual: $netPrice->getPrice() + $vatPrice->getPrice());
    }

    /**
     * @return array
     */
    public static function dataProviderSalesTaxOfTotal(): array
    {
        $firstGrossPrice = Price::create(price: 24);

        $vat = Vat::create(vat: 19);
        $firstNetPrice = Price::create(price: 20);

        $expectedVatPrice = Price::create(price: 4);

        $secondGrossPrice = Price::create(price: 30000);

        $secondNetPrice = Price::create(price: 25210);

        $expectedSecondVatPrice = Price::create(price: 4790);

        $thirdGrossPrice = Price::create(price: 1500);

        $thirdNetPrice = Price::create(price: 1261);

        $expectedThirdVatPrice = Price::create(price: 239);

        return [
            [
                $firstGrossPrice,
                $vat,
                $firstNetPrice,
                $expectedVatPrice,
            ],
            [
                $secondGrossPrice,
                $vat,
                $secondNetPrice,
                $expectedSecondVatPrice,
            ],
            [
                $thirdGrossPrice,
                $vat,
                $thirdNetPrice,
                $expectedThirdVatPrice,
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderPriceWithSalesTax')]
    public function canCalculatePriceWithSalesTax(Price $netPrice, Vat $vat, Price $expectedPrice): void
    {
        $vatCalculator = new VatCalculator(vat: $vat, priceCalculator: new PriceCalculator());

        $calculatedPrice = $vatCalculator->calculatePriceWithSalesTax(netPrice: $netPrice);

        $this->assertSame(expected: $expectedPrice->getPrice(), actual: $calculatedPrice->getPrice());
    }

    /**
     * @return array
     */
    public static function dataProviderPriceWithSalesTax(): array
    {
        $lowPrice = Price::create(price: 3151);
        $vat = Vat::create(vat: 19);
        $expectedLowPrice = Price::create(price: 3750);

        $secondPrice = Price::create(price: 25200);

        $expectedSecondPrice = Price::create(price: 29988);

        $thirdPrice = Price::create(price: 15);

        $expectedThirdPrice = Price::create(price: 18);

        return [
            [
                $lowPrice,
                $vat,
                $expectedLowPrice,
            ],
            [
                $secondPrice,
                $vat,
                $expectedSecondPrice,
            ],
            [
                $thirdPrice,
                $vat,
                $expectedThirdPrice,
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCalculateNetPriceFromGrossPrice')]
    public function canCalculateNetPriceFromGrossPrice(Price $grossPrice, Vat $vat, Price $expectedNetPrice): void
    {
        $vatCalculator = new VatCalculator(vat: $vat, priceCalculator: new PriceCalculator());
        $netPrice = $vatCalculator->calculateNetPriceFromGrossPrice(total: $grossPrice);

        $this->assertSame(expected: $expectedNetPrice->getPrice(), actual: $netPrice->getPrice());
    }

    /**
     * @return array
     */
    public static function dataProviderCalculateNetPriceFromGrossPrice(): array
    {
        $lowPrice = Price::create(price: 3750);
        $vat = Vat::create(vat: 19);

        $expectedLowPrice = Price::create(price: 3151);

        $secondPrice = Price::create(price: 29988);

        $expectedSecondPrice = Price::create(price: 25200);

        $thirdPrice = Price::create(price: 18);

        $expectedThirdPrice = Price::create(price: 15);

        return [
            [
                $lowPrice,
                $vat,
                $expectedLowPrice,
            ],
            [
                $secondPrice,
                $vat,
                $expectedSecondPrice,
            ],
            [
                $thirdPrice,
                $vat,
                $expectedThirdPrice,
            ],
        ];
    }
}
