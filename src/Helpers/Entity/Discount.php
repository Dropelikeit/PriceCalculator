<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Types\DiscountInterface;
use MarcelStrahl\PriceCalculator\Helpers\Types\PercentInterface;

/**
 * Class Discount
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
class Discount implements DiscountInterface, PercentInterface
{
    /**
     * @var float
     */
    private $percent = .0;

    /**
     * @param float $percent
     */
    public function __construct(float $percent)
    {
        $this->percent = $percent;
    }

    /**
     * @inheritDoc
     */
    public function getDiscount(): float
    {
        return $this->percent;
    }
}
