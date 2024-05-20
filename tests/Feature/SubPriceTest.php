<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Feature;

use MarcelStrahl\PriceCalculator\Contracts\PriceCalculatorInterface;
use MarcelStrahl\PriceCalculator\Contracts\View\Formatter;
use MarcelStrahl\PriceCalculator\Facade\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\EuroToCent;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class SubPriceTest extends TestCase
{
    private readonly PriceCalculatorInterface $priceCalculator;
    private readonly Formatter $formatter;

    public function setUp(): void
    {
        parent::setUp();
        $this->priceCalculator = PriceCalculator::getPriceCalculator();
        $this->formatter = new PriceFormatter(2, ',', '.', '€');
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanSubCentPrice')]
    public function canSubCentPrice(
        Price $total,
        Price $subPrice,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void {
        $calculatedPrice = $this->priceCalculator->subPrice($total, $subPrice);

        $this->assertEquals($expectedPrice, $calculatedPrice->getPrice());

        $converter = new CentToEuro();
        $convertedPrice = $converter->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    /**
     * @return array{
     *     same_price: array{0: Price, 1: Price, 2: 0, 3: '0,00 €'},
     *     different_prices: array{0: Price, 1: Price, 2: 500, 3: '5,00 €'},
     *     result_is_lower_than_zero: array{0: Price, 1: Price, 2: 0, 3: '0,00 €'},
     * }
     */
    public static function dataProviderCanSubCentPrice(): array
    {
        $samePrice = Price::create(12);

        $differentTotalPrice = Price::create(1500);

        $differentSubPrice = Price::create(1000);

        $totalPriceIsLowerThanZero = Price::create(100);

        $secondPriceIsLowerThanZero = Price::create(200);

        return [
            'same_price' => [
                $samePrice,
                $samePrice,
                0,
                '0,00 €',
            ],
            'different_prices' => [
                $differentTotalPrice,
                $differentSubPrice,
                500,
                '5,00 €',
            ],
            'result_is_lower_than_zero' => [
                $totalPriceIsLowerThanZero,
                $secondPriceIsLowerThanZero,
                0,
                '0,00 €',
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanSubEuroPrice')]
    public function canSubEuroPrice(
        float $total,
        float $subPrice,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void {
        $euroToCent = new EuroToCent();

        $totalInCent = $euroToCent->convert($total);
        $subPriceInCent = $euroToCent->convert($subPrice);

        $totalPrice = Price::create((int) $totalInCent);

        $sub = Price::create((int) $subPriceInCent);

        $calculatedPrice = $this->priceCalculator->subPrice($totalPrice, $sub);

        $this->assertEquals($expectedPrice, $calculatedPrice->getPrice());

        $centToEuro = new CentToEuro();
        $convertedPrice = $centToEuro->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    /**
     * @return array{
     *     same_price: array{0: 15.51, 1: 15.51, 2: 0, 3: '0,00 €'},
     *     different_prices: array{0: 20.85, 1: 19.99, 2: 86, 3: '0,86 €'},
     *     result_is_lower_than_zero: array{0: 1.00, 1: 2.85, 2: 0, 3: '0,00 €'},
     * }
     */
    public static function dataProviderCanSubEuroPrice(): array
    {
        return [
            'same_price' => [
                15.51,
                15.51,
                0,
                '0,00 €',
            ],
            'different_prices' => [
                20.85,
                19.99,
                86,
                '0,86 €',
            ],
            'result_is_lower_than_zero' => [
                1.00,
                2.85,
                0,
                '0,00 €',
            ],
        ];
    }
}
