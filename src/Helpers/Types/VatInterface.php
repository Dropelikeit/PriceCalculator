<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Types;

/**
 * Interface VatInterface
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
interface VatInterface
{
    /**
     * @param int $vat
     * @return void
     */
    public function setVat(int $vat): void;

    /**
     * @return int
     */
    public function getVat(): int;
}
