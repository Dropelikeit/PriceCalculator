<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

/**
 * Class CentToEuro
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Converter
 */
class CentToEuro implements ConverterInterface
{
    /**
     * @var float
     */
    private $amount = 0;

    /**
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @inheritDoc
     */
    public function convert(): float
    {
        return (float)bcdiv($this->amount, 100, 2);
    }
}
