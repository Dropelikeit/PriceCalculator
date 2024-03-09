<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Factory;

use MarcelStrahl\PriceCalculator\Exceptions\PriceCalculatorFactoryException;
use MarcelStrahl\PriceCalculator\Factory\Converter;
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\CentToEuro;
use MarcelStrahl\PriceCalculator\Helpers\Converter\Currencies\EuroToCent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: Converter::class)]
#[UsesClass(className: PriceCalculatorFactoryException::class)]
final class ConverterFactoryTest extends TestCase
{
    #[Test]
    public function hasImplemented(): void
    {
        $converterFactory = new Converter();
        $this->assertInstanceOf(ConverterFactoryInterface::class, $converterFactory);
        $this->assertInstanceOf(Converter::class, $converterFactory);
    }

    /**
     * @param class-string $expectedClass
     */
    #[Test]
    #[DataProvider(methodName: 'dataProviderGetConverter')]
    public function testGetConverter(string $destinationUnit, string $expectedClass): void
    {
        $factory = new Converter();

        if ($destinationUnit === '') {
            $this->expectException(PriceCalculatorFactoryException::class);
            $this->expectExceptionCode(500);
            $this->expectExceptionMessage('The required currency translation is not currently supported. Type: ');
        }
        $converter = $factory->factorize($destinationUnit);

        $this->assertInstanceOf($expectedClass, $converter);
    }

    /**
     * @return array{
     *     0: array{0: 'cent_to_euro', 1: CentToEuro},
     *     1: array{0: 'euro_to_cent', 1: EuroToCent},
     *     2: array{0: '', 1: ''}
     * }
     */
    public static function dataProviderGetConverter(): array
    {
        return [
            [ConverterFactoryInterface::CENT_TO_EURO, CentToEuro::class],
            [ConverterFactoryInterface::EURO_TO_CENT, EuroToCent::class],
            ['', ''],
        ];
    }
}
