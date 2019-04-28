<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Types\DiscountInterface;

/**
 * Class Discount
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
class Discount implements DiscountInterface
{
    /**
     * @var int
     */
    private $percent;

    /**
     * @param int $percent
     */
    public function __construct(int $percent)
    {
        $this->percent = $percent;
    }

    /**
     * {@inheritdoc}
     */
    public function getDiscount(): int
    {
        return $this->percent;
    }
}
