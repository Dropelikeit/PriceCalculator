<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Feature;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class VatCalculationTest extends TestCase
{
    private readonly VatCalculator $vatCalculator;

    public function setUp(): void
    {
        parent::setUp();

        $vat = Vat::create(vat: 19);

        $this->vatCalculator = new VatCalculator(vat: $vat, priceCalculator: new PriceCalculator());
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanCalculatePriceWithSalesTax')]
    public function canCalculatePriceWithSalesTax(Price $netPrice, Price $expectedGrossPrice): void
    {
        $grossPrice = $this->vatCalculator->calculatePriceWithSalesTax(netPrice: $netPrice);

        $this->assertEquals(expected: $expectedGrossPrice->getPrice(), actual: $grossPrice->getPrice());
    }

    /**
     * @return array{
     *     0: array{1: Price, 2: Price},
     *     1: array{1: Price, 2: Price},
     *     2: array{1: Price, 2: Price}
     * }
     */
    public static function dataProviderCanCalculatePriceWithSalesTax(): array
    {
        $firstTestCase = Price::create(price: 1200); // 12,00 €

        $expectedFirstGrossPrice = Price::create(price: 1428); // 14,28 €

        $secondTestCase = Price::create(price: 10599); // 105,99 €

        $expectedSecondGrossPrice = Price::create(price: 12613); // 126,13 €

        $thirdTestCase = Price::create(price: 411); // 4,11 €

        $expectedThirdGrossPrice = Price::create(price: 489); // 4,89 €

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

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanCalculateSalesTaxFromTotalPrice')]
    public function canCalculateSalesTaxFromTotalPrice(Price $total, Price $expectedSalesTax): void
    {
        $salesTax = $this->vatCalculator->calculateSalesTaxFromTotalPrice(total: $total);

        $this->assertEquals(expected: $expectedSalesTax->getPrice(), actual: $salesTax->getPrice());
    }

    /**
     * @return array{
     *      0: array{1: Price, 2: Price},
     *      1: array{1: Price, 2: Price}
     * }
     */
    public static function dataProviderCanCalculateSalesTaxFromTotalPrice(): array
    {
        $firstGrossPrice = Price::create(price: 1428); // 14,28 €

        $salesTaxFromFirstGrossPrice = Price::create(price: 228); // 2,28 €

        $secondGrossPrice = Price::create(price: 12613); // 126,13 €

        $salesTaxFromSecondGrossPrice = Price::create(price: 2014); // 20,14 €

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

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanCalculateNetPriceFromGrossPrice')]
    public function canCalculateNetPriceFromGrossPrice(Price $total, Price $expectedNetPrice): void
    {
        $netPrice = $this->vatCalculator->calculateNetPriceFromGrossPrice(total: $total);

        $this->assertEquals(expected: $expectedNetPrice->getPrice(), actual: $netPrice->getPrice());
    }

    /**
     * @return array{
     *      0: array{1: Price, 2: Price},
     *      1: array{1: Price, 2: Price}
     * }
     */
    public static function dataProviderCanCalculateNetPriceFromGrossPrice(): array
    {
        $firstTestCase = Price::create(price: 1428); // 14,28 €

        $expectedFirstNetPrice = Price::create(price: 1200); // 12,00 €

        $secondTestCase = Price::create(price: 12613); // 126,13 €

        $expectedSecondNetPrice = Price::create(price: 10599); // 105,99 €

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
