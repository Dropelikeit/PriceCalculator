<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Contracts\Type;

/**
 * Interface Discount
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
interface DiscountInterface
{
    public function getDiscount(): float;
}
