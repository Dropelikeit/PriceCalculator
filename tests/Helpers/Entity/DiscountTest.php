<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Tests\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Contracts\Type\DiscountInterface;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
#[CoversClass(className: Discount::class)]
final class DiscountTest extends TestCase
{
    #[Test]
    #[DataProvider(methodName: 'dataProviderCreateDiscount')]
    public function canSetDiscount(int $discount, float $expectedDiscount): void
    {
        $discount = new Discount($discount);
        $this->assertInstanceOf(DiscountInterface::class, $discount);
        $this->assertSame($expectedDiscount, $discount->getDiscount());
    }

    /**
     * @return array{
     *     create_discount_successfully: array{0: 100, 1: 100}
     * }
     */
    public static function dataProviderCreateDiscount(): array
    {
        return [
            'create_discount_successfully' => [
                100,
                100,
            ],

        ];
    }

    #[Test]
    #[DataProvider(methodName: 'dataProviderCannotCreateDiscount')]
    public function canNotSetDiscount(mixed $discount, bool $expectedException): void
    {
        if ($expectedException) {
            $this->expectException(TypeError::class);
        }

        /** @phpstan-ignore-next-line */
        new Discount($discount);
    }

    /**
     * @return array{
     *     failed_by_string: array{0: non-empty-string, 1: true},
     *     failed_by_object: array{0: stdClass, 1: true}
     * }
     */
    public static function dataProviderCannotCreateDiscount(): array
    {
        return [
            'failed_by_string' => [
                'hello',
                true,
            ],
            'failed_by_object' => [
                new stdClass(),
                true,
            ],
        ];
    }
}
