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
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class AddPriceTest extends TestCase
{
    /**
     * @var PriceCalculatorInterface
     */
    private PriceCalculatorInterface $priceCalculator;

    /**
     * @var Formatter
     */
    private Formatter $formatter;

    public function setUp(): void
    {
        parent::setUp();

        $this->priceCalculator = PriceCalculator::getPriceCalculator();
        $this->formatter = new PriceFormatter(2, ',', '.', '€');
    }

    /**
     * @test
     * @dataProvider dataProviderCanAddCentPrices
     * @param Price $total
     * @param Price $addPrice
     * @param int $expectedPrice
     * @param string $expectedFormattedPrice
     */
    public function canAddCentPrices(
        Price $total,
        Price $addPrice,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void
    {
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
    public function dataProviderCanAddCentPrices(): array
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

    /**
     * @test
     * @dataProvider dataProviderCanAddEuroPrice
     * @param float $total
     * @param float $addPrice
     * @param int $expectedCalculatedPrice
     * @param string $expectedFormattedPrice
     */
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

    public function dataProviderCanAddEuroPrice(): array
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
