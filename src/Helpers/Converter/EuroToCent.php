<?php

namespace MarcelStrahl\PriceCalculator\Helpers\Converter;

/**
 * Class EuroToCent
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Converter
 */
class EuroToCent implements ConverterInterface
{
    /**
     * @var float
     */
    private $amount = 0.00;

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
        return (float)bcmul($this->amount, 100);
    }
}
