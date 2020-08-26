<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points;

use Money\Money;

/**
 * Class Point
 *
 * @package Rarus\BonusServer\Transactions\DTO\Points
 */
final class Point
{
    /**
     * @var Money
     */
    private $sum;
    /**
     * @var \DateTime
     */
    private $dateCreate;
    /**
     * @var null|\DateTime
     */
    private $activeFrom;
    /**
     * @var null|\DateTime
     */
    private $activeTo;

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
     * @return Point
     */
    public function setSum(Money $sum): Point
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTime $dateCreate
     *
     * @return Point
     */
    public function setDateCreate(\DateTime $dateCreate): Point
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getActiveFrom(): ?\DateTime
    {
        return $this->activeFrom;
    }

    /**
     * @param \DateTime|null $activeFrom
     *
     * @return Point
     */
    public function setActiveFrom(\DateTime $activeFrom): Point
    {
        $this->activeFrom = $activeFrom;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getActiveTo(): ?\DateTime
    {
        return $this->activeTo;
    }

    /**
     * @param \DateTime|null $activeTo
     *
     * @return Point
     */
    public function setActiveTo(\DateTime $activeTo): Point
    {
        $this->activeTo = $activeTo;

        return $this;
    }
}
