<?php
declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Types\DiscountInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class Discount implements DiscountInterface
{
    private float $percent;

    public function __construct(float $percent)
    {
        $this->percent = $percent;
    }

    public function getDiscount(): float
    {
        return $this->percent;
    }
}
