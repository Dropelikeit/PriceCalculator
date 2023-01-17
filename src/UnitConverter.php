<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator;

use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class UnitConverter implements UnitConverterInterface
{
    /**
     * @var ConverterFactoryInterface
     */
    private ConverterFactoryInterface $factory;

    /**
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
