<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Feature;

use MarcelStrahl\PriceCalculator\Facade\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\EuroToCent;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\View\Formatter;
use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class DivPriceTest extends TestCase
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
    #[DataProvider(methodName: 'dataProviderCanDivCentPrice')]
    public function canDivCentPrice(
        int $amount,
        Price $total,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void {
        $calculatedPrice = $this->priceCalculator->divPrice($amount, $total);

        $this->assertEquals($expectedPrice, $calculatedPrice->getPrice());

        $converter = new CentToEuro();
        $convertedPrice = $converter->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    /**
     * @return array{
     *     easy_div_calculation: array{0: 9, 1: Price, 2: 1, 3: '0,01 €'},
     *     different_prices: array{0: 15, 1: Price, 2: 0, 3: '0,00 €'},
     *     result_is_lower_than_zero: array{0: 9, 1: Price, 2: 0, 3: '0,00 €'}
     * }
     */
    public static function dataProviderCanDivCentPrice(): array
    {
        $easyDivCalculation = Price::create(9);
        $differentTotalPrice = Price::create(5);
        $totalPriceIsLowerThanZero = Price::create(0);

        return [
            'easy_div_calculation' => [
                9,
                $easyDivCalculation,
                1,
                '0,01 €',
            ],
            'different_prices' => [
                15,
                $differentTotalPrice,
                0,
                '0,00 €',
            ],
            'result_is_lower_than_zero' => [
                9,
                $totalPriceIsLowerThanZero,
                0,
                '0,00 €',
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanDivEuroPrice')]
    public function canDivEuroPrice(
        int $amount,
        float $total,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void {
        $euroToCent = new EuroToCent();

        $totalInCent = $euroToCent->convert($total);

        $totalPrice = Price::create((int) $totalInCent);

        $calculatedPrice = $this->priceCalculator->divPrice($amount, $totalPrice);

        $this->assertEquals($expectedPrice, $calculatedPrice->getPrice());

        $centToEuro = new CentToEuro();
        $convertedPrice = $centToEuro->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    /**
     * @return array{
     *     easy_div_calculation: array{0: 9, 1: 0.09, 2: 1, 3: '0,01 €'},
     *     different_prices: array{0: 15, 1: 0.05, 2: 0, 3: '0,00 €'},
     *     result_is_lower_than_zero: array{0: 9, 1: 0.00, 2: 0, 3: '0,00 €'}
     * }
     */
    public static function dataProviderCanDivEuroPrice(): array
    {
        return [
            'easy_div_calculation' => [
                9,
                0.09,
                1,
                '0,01 €',
            ],
            'different_prices' => [
                15,
                0.05,
                0,
                '0,00 €',
            ],
            'result_is_lower_than_zero' => [
                9,
                0.00,
                0,
                '0,00 €',
            ],
        ];
    }
}
