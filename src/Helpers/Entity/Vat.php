<?php

declare(strict_types=1);

namespace MarcelStrahl\PriceCalculator\Helpers\Entity;

use MarcelStrahl\PriceCalculator\Helpers\Types\VatInterface;

/**
 * Class Vat
 * @author Marcel Strahl <info@marcel-strahl.de>
 * @package MarcelStrahl\PriceCalculator\Helpers\Entity
 */
class Vat implements VatInterface
{
    /**
     * @var int
     */
    private int $vat = 0;

    /**
     * @return int
     */
    public function getVat(): int
    {
        return $this->vat;
    }

    /**
     * @param int $vat
     * @return void
     */
    public function setVat(int $vat): void
    {
        $this->vat = $vat;
    }
}
