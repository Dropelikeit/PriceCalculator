<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Contracts\Type;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface VatInterface
{
    public static function create(int $vat): self;

    public function getVat(): int;
}
