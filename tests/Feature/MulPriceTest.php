<?php

namespace MarcelStrahl\PriceCalculator\Tests\Feature;

use MarcelStrahl\PriceCalculator\Facade\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\View\Formatter;
use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;
use MarcelStrahl\PriceCalculator\PriceCalculatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class MulPriceTest extends TestCase
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
     * @dataProvider dataProviderCanMulCentPrice
     */
    public function canMulCentPrice(
        Price $amount,
        Price $total,
        int $expectedPrice,
        string $expectedFormattedPrice
    ): void
    {
        $calculatedPrice = $this->priceCalculator->mulPrice($amount, $total);

        $this->assertEquals($expectedPrice, $calculatedPrice->getPrice());

        $converter = new CentToEuro();
        $convertedPrice = $converter->convert($calculatedPrice->getPrice());

        $formattedPrice = $this->formatter->formatPrice($convertedPrice);

        $this->assertEquals($expectedFormattedPrice, $formattedPrice);
    }

    public function dataProviderCanMulCentPrice(): array
    {
        $easyMulCalculation = new Price();
        $easyMulCalculation->setPrice(9);

        $easyMulCalculationAmount = new Price();
        $easyMulCalculationAmount->setPrice(9);

        $differentTotalPrice = new Price();
        $differentTotalPrice->setPrice(5);

        $differentAmount = new Price();
        $differentAmount->setPrice(15);

        $totalPriceIsLowerThanZero = new Price();
        $totalPriceIsLowerThanZero->setPrice(0);

        $amountOfIsLowerThanZero = new Price();
        $amountOfIsLowerThanZero->setPrice(9);

        $highTotalPrice = new Price();
        $highTotalPrice->setPrice(5000);

        $highAmount = new Price();
        $highAmount->setPrice(50000);

        $highFloatPriceAmount = new Price();
        $highFloatPriceAmount->setPrice(500);

        $highFloatPriceTotal = new Price();
        $highFloatPriceTotal->setPrice(59596);

        return [
            'easy_div_calculation' => [
                $easyMulCalculationAmount,
                $easyMulCalculation,
                81,
                '0,81 €',
            ],
            'different_prices' => [
                $differentAmount,
                $differentTotalPrice,
                75,
                '0,75 €',
            ],
            'result_is_lower_than_zero' => [
                $amountOfIsLowerThanZero,
                $totalPriceIsLowerThanZero,
                0,
                '0,00 €',
            ],
            'use_high_numbers' => [
                $highAmount,
                $highTotalPrice,
                250000000,
                '2.500.000,00 €',
            ],
            'use_high_float_price' => [
                $highFloatPriceAmount,
                $highFloatPriceTotal,
                29798000,
                '297.980,00 €',
            ],
        ];
    }
}
