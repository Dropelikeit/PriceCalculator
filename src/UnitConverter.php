<?php

namespace MarcelStrahl\PriceCalculator;

use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * Class UnitConverter
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator
 */
class UnitConverter implements UnitConverterInterface
{
    /**
     * @var ConverterFactoryInterface
     */
    private $factory;

    /**
     * UnitConverter constructor.
     * @param ConverterFactoryInterface $factory
     */
    public function __construct(ConverterFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(string $destinationUnit): ConverterInterface
    {
        return $this->factory->factorize($destinationUnit);
    }
}
