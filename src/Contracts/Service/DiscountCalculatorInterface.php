<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Contracts\Service;

use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

interface DiscountCalculatorInterface
{
    public function calculateDiscountFromTotal(Price $total, Discount $discount): Price;

    public function calculateDiscountPriceFromTotal(Price $total, Discount $discount): Price;
}
