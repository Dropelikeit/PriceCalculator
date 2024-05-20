<?php
declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Contracts\Type;

interface FiguresInterface
{
    public const INTEGER_ZERO = 0;
    public const INTEGER_ONE = 1;
    public const INTEGER_TWO = 2;
    public const INTEGER_HUNDRED = 100;

    public const FLOAT_ZERO = .0;

    public const STRING_HUNDRED = '100';
}