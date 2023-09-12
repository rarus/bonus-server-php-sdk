<?php

declare(strict_types=1);

namespace Rarus\BonusServer\DiscountConditions\DTO;

use Rarus\BonusServer\Discounts\DTO\DiscountId;

final class DiscountConditionFilter
{
    /**
     * @var DiscountId | null
     */
    private $discountId;

    /**
     * @var int | null
     */
    private $type;

    /**
     * @var int | null
     */
    private $function;

    /**
     * @var bool | null
     */
    private $active;

    /**
     * @return DiscountId|null
     */
    public function getDiscountId(): ?DiscountId
    {
        return $this->discountId;
    }

    /**
     * @param DiscountId|null $discountId
     * @return DiscountConditionFilter
     */
    public function setDiscountId(?DiscountId $discountId): DiscountConditionFilter
    {
        $this->discountId = $discountId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     * @return DiscountConditionFilter
     */
    public function setType(?int $type): DiscountConditionFilter
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFunction(): ?int
    {
        return $this->function;
    }

    /**
     * @param int|null $function
     * @return DiscountConditionFilter
     */
    public function setFunction(?int $function): DiscountConditionFilter
    {
        $this->function = $function;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     * @return DiscountConditionFilter
     */
    public function setActive(?bool $active): DiscountConditionFilter
    {
        $this->active = $active;
        return $this;
    }

}
