<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Balance;

use Money\Money;

/**
 * Class Balance
 *
 * @package Rarus\BonusServer\Cards\DTO\Balance
 */
final class Balance
{
    /**
     * @var Money
     */
    private $total;
    /**
     * @var Money
     */
    private $available;

    /**
     * @return Money
     */
    public function getTotal(): Money
    {
        return $this->total;
    }

    /**
     * @param Money $total
     *
     * @return Balance
     */
    public function setTotal(Money $total): Balance
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAvailable(): Money
    {
        return $this->available;
    }

    /**
     * @param Money $available
     *
     * @return Balance
     */
    public function setAvailable(Money $available): Balance
    {
        $this->available = $available;

        return $this;
    }
}
