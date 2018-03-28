<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Types;

/**
 * Interface Discount
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
interface DiscountInterface
{
    /**
     * @return float
     */
    public function getDiscount(): float;
}
