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
class SubPriceTest extends TestCase
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
     * @dataProvider dataProviderCanSubCentPrice
     * @param Price $total
     * @param Price $subPrice
     * @param int $expectedPrice
     * @param string $expectedFormattedPrice
     */
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

    public function dataProviderCanSubCentPrice(): array
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

    /**
     * @test
     * @dataProvider dataProviderCanSubEuroPrice
     * @param float $total
     * @param float $subPrice
     * @param int $expectedPrice
     * @param string $expectedFormattedPrice
     */
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

    public function dataProviderCanSubEuroPrice(): array
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
