<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Types;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface VatInterface
{
    public function setVat(int $vat): void;

    public function getVat(): int;
}
