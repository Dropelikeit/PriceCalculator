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
class DivPriceTest extends TestCase
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
     * @dataProvider dataProviderCanDivCentPrice
     * @param int $amount
     * @param Price $total
     * @param int $expectedPrice
     * @param string $expectedFormattedPrice
     */
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

    public function dataProviderCanDivCentPrice(): array
    {
        $easyDivCalculation = new Price();
        $easyDivCalculation->setPrice(9);

        $differentTotalPrice = new Price();
        $differentTotalPrice->setPrice(5);

        $totalPriceIsLowerThanZero = new Price();
        $totalPriceIsLowerThanZero->setPrice(0);

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

    /**
     * @test
     * @dataProvider dataProviderCanDivEuroPrice
     * @param int $amount
     * @param float $total
     * @param int $expectedPrice
     * @param string $expectedFormattedPrice
     */
    public function canDivEuroPrice(
        int $amount,
        float $total,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void
    {
        $euroToCent = new EuroToCent();

        $totalInCent = $euroToCent->convert($total);

        $totalPrice = new Price();
        $totalPrice->setPrice((int) $totalInCent);

        $calculatedPrice = $this->priceCalculator->divPrice($amount, $totalPrice);

        $this->assertEquals($expectedPrice, $calculatedPrice->getPrice());

        $centToEuro = new CentToEuro();
        $convertedPrice = $centToEuro->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    public function dataProviderCanDivEuroPrice(): array
    {
        $easyDivCalculation = new Price();
        $easyDivCalculation->setPrice(9);

        $differentTotalPrice = new Price();
        $differentTotalPrice->setPrice(5);

        $totalPriceIsLowerThanZero = new Price();
        $totalPriceIsLowerThanZero->setPrice(0);

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
