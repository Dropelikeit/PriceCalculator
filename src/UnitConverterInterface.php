<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator;

use MarcelStrahl\PriceCalculator\Helpers\Converter\ConverterInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator
 */
interface UnitConverterInterface
{
    /**
     * @param string $destinationUnit
     * @return ConverterInterface
     */
    public function convert(string $destinationUnit): ConverterInterface;
}
