<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Facade;

use MarcelStrahl\PriceCalculator\Factory\Converter as ConverterFactory;
use MarcelStrahl\PriceCalculator\UnitConverter as UnitConverterService;

/**
 * Class UnitConverter
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Facade
 */
class UnitConverter
{
    /**
     * @return UnitConverterService
     */
    public static function getConverter(): UnitConverterService
    {
        return (new self())->createUnitConverter();
    }

    /**
     * @return UnitConverterService
     */
    private function createUnitConverter(): UnitConverterService
    {
        return new UnitConverterService($this->createFactory());
    }

    /**
     * @return ConverterFactory
     */
    private function createFactory(): ConverterFactory
    {
        return new ConverterFactory();
    }
}
