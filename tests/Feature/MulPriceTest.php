<?php

declare(strict_types=1);

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
     * @dataProvider dataProviderCanMulCentPrice
     * @param Price $amount
     * @param Price $total
     * @param int $expectedPrice
     * @param string $expectedFormattedPrice
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
        $easyMulCalculation = Price::create(9);
        $easyMulCalculationAmount = Price::create(9);
        $differentTotalPrice = Price::create(5);
        $differentAmount = Price::create(15);
        $totalPriceIsLowerThanZero = Price::create(0);
        $amountOfIsLowerThanZero = Price::create(9);
        $highTotalPrice = Price::create(5000);
        $highAmount = Price::create(50000);
        $highFloatPriceAmount = Price::create(500);

        $highFloatPriceTotal = Price::create(59596);

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
