<?php

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
    private $priceCalculator;

    /**
     * @var Formatter
     */
    private $formatter;

    public function setUp(): void
    {
        parent::setUp();

        $this->priceCalculator = PriceCalculator::getPriceCalculator();
        $this->formatter = new PriceFormatter(2, ',', '.', '€');
    }

    /**
     * @test
     * @dataProvider dataProviderCanAddCentPrices
     */
    public function canAddCentPrices(Price $total, Price $addPrice, int $expectedPrice, string $expectedFormattedPrice)
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

    public function dataProviderCanAddCentPrices(): array
    {
        $samePrice = new Price();
        $samePrice->setPrice(300);

        $firstDifferentPrice = new Price();
        $firstDifferentPrice->setPrice(149);

        $secondDifferentPrice = new Price();
        $secondDifferentPrice->setPrice(1034);

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

        $totalPrice = new Price();
        $totalPrice->setPrice((int) $totalPriceInCent);

        $addPrice = new Price();
        $addPrice->setPrice((int) $addPriceInCent);

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
