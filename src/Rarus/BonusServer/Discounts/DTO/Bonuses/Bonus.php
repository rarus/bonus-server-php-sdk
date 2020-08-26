<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO\Bonuses;

use Money\Money;

/**
 * Class Bonus
 *
 * @package Rarus\BonusServer\Discounts\DTO\Bonuses
 */
class Bonus
{
    /**
     * @var Money
     */
    private $sum;

    /**
     * @var float
     */
    private $percent;

    /**
     * @return Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }

    /**
     * @param Money $sum
     *
     * @return Bonus
     */
    public function setSum(Money $sum): Bonus
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return float
     */
    public function getPercent(): float
    {
        return $this->percent;
    }

    /**
     * @param float $percent
     *
     * @return Bonus
     */
    public function setPercent(float $percent): Bonus
    {
        $this->percent = $percent;

        return $this;
    }
}
