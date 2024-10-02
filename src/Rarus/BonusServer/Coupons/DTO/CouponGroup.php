<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Coupons\DTO;

final class CouponGroup
{
    /**
     * @var CouponGroupId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $type;

    /**
     * @var bool
     */
    private $oncard;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @var \DateTime | null
     */
    private $startDate;
    /**
     * @var \DateTime | null
     */
    private $endDate;

    /**
     * @var int
     */
    private $periodType;

    /**
     * @var int
     */
    private $useDays;

    /**
     * @var int
     */
    private $offsetActivationDays;

    /**
     * @var CouponGroupId
     */
    private $parentId;

    /**
     * @var bool
     */
    private $isgroup;

    public function getId(): CouponGroupId
    {
        return $this->id;
    }

    public function setId(CouponGroupId $id): CouponGroup
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CouponGroup
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): CouponGroup
    {
        $this->description = $description;
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): CouponGroup
    {
        $this->type = $type;
        return $this;
    }

    public function isOncard(): bool
    {
        return $this->oncard;
    }

    public function setOncard(bool $oncard): CouponGroup
    {
        $this->oncard = $oncard;
        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): CouponGroup
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): CouponGroup
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): CouponGroup
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getPeriodType(): int
    {
        return $this->periodType;
    }

    public function setPeriodType(int $periodType): CouponGroup
    {
        $this->periodType = $periodType;
        return $this;
    }

    public function getUseDays(): int
    {
        return $this->useDays;
    }

    public function setUseDays(int $useDays): CouponGroup
    {
        $this->useDays = $useDays;
        return $this;
    }

    public function getOffsetActivationDays(): int
    {
        return $this->offsetActivationDays;
    }

    public function setOffsetActivationDays(int $offsetActivationDays): CouponGroup
    {
        $this->offsetActivationDays = $offsetActivationDays;
        return $this;
    }

    public function getParentId(): CouponGroupId
    {
        return $this->parentId;
    }

    public function setParentId(CouponGroupId $parentId): CouponGroup
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function isIsgroup(): bool
    {
        return $this->isgroup;
    }

    public function setIsgroup(bool $isgroup): CouponGroup
    {
        $this->isgroup = $isgroup;
        return $this;
    }
}
