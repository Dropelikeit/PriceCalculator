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
final class AddPriceTest extends TestCase
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
    #[DataProvider(methodName: 'dataProviderCanAddCentPrices')]
    public function canAddCentPrices(
        Price $total,
        Price $addPrice,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void {
        $priceCalculator = PriceCalculator::getPriceCalculator();

        $this->assertInstanceOf(PriceCalculatorInterface::class, $priceCalculator);

        $calculatedPrice = $priceCalculator->addPrice($total, $addPrice);

        $this->assertEquals($expectedPrice, $calculatedPrice->getPrice());

        $converter = new CentToEuro();

        $convertedPrice = $converter->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    /**
     * @return array<string, array<int, Price|int|string>>
     */
    public static function dataProviderCanAddCentPrices(): array
    {
        $samePrice = Price::create(300);

        $firstDifferentPrice = Price::create(149);

        $secondDifferentPrice = Price::create(1034);

        return [
            'same_first_and_second_price' => [
                $samePrice,
                $samePrice,
                600,
                '6,00 €',
            ],
            'first_and_second_price_are_different' => [
                $firstDifferentPrice,
                $secondDifferentPrice,
                1183,
                '11,83 €',
            ],
        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCanAddEuroPrice')]
    public function canAddEuroPrice(
        float $total,
        float $addPrice,
        int $expectedCalculatedPrice,
        string $expectedFormattedPrice
    ): void {
        $euroToCentConverter = new EuroToCent();
        $totalPriceInCent = $euroToCentConverter->convert($total);
        $addPriceInCent = $euroToCentConverter->convert($addPrice);

        $totalPrice = Price::create((int) $totalPriceInCent);
        $addPrice = Price::create((int) $addPriceInCent);

        $calculatedPrice = $this->priceCalculator->addPrice($totalPrice, $addPrice);

        $this->assertEquals($expectedCalculatedPrice, $calculatedPrice->getPrice());

        $centToEuroConverter = new CentToEuro();
        $convertedPrice = $centToEuroConverter->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    /**
     * @return array{
     *     same_price: array{0: float, 1: float, 2: int, 3: string},
     *     first_and_second_price_are_different: array{0: float, 1: float, 2: int, 3: string}
     * }
     */
    public static function dataProviderCanAddEuroPrice(): array
    {
        return [
            'same_price' => [
                3.00,
                3.00,
                600,
                '6,00 €',
            ],
            'first_and_second_price_are_different' => [
                1.49,
                10.34,
                1183,
                '11,83 €',
            ],
        ];
    }
}
