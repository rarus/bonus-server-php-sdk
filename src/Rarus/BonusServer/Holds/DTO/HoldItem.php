<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\DTO;

use Money\Money;

final class HoldItem
{
    /**
     * @var HoldId
     */
    private $holdId;

    /**
     * @var bool|null
     */
    private $holdUsed = true;

    /**
     * @var Money
     */
    private $holdSum;

    /**
     * @param HoldId $holdId
     * @param bool|null $holdUsed
     * @param Money $holdSum
     */
    public function __construct(HoldId $holdId, ?bool $holdUsed, Money $holdSum)
    {
        $this->holdId = $holdId;
        $this->holdUsed = $holdUsed;
        $this->holdSum = $holdSum;
    }

    public function getHoldId(): HoldId
    {
        return $this->holdId;
    }

    public function getHoldUsed(): ?bool
    {
        return $this->holdUsed;
    }

    public function getHoldSum(): Money
    {
        return $this->holdSum;
    }
}
