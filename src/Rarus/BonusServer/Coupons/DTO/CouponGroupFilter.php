<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Coupons\DTO;

final class CouponGroupFilter
{
    /**
     * @var int|null
     */
    private $type;

    /**
     * @var \DateTime|null
     */
    private $startDateFrom;

    /**
     * @var \DateTime|null
     */
    private $startDateTo;

    /**
     * @var \DateTime|null
     */
    private $endDateFrom;

    /**
     * @var \DateTime|null
     */
    private $endDateTo;

    /**
     * @var CouponGroupId|null
     */
    private $parentId;

    /**
     * @var string
     */
    private $nameFilter = '';

    /**
     * @var bool
     */
    private $showDeleted = false;

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): CouponGroupFilter
    {
        $this->type = $type;
        return $this;
    }

    public function getStartDateFrom(): ?\DateTime
    {
        return $this->startDateFrom;
    }

    public function setStartDateFrom(?\DateTime $startDateFrom): CouponGroupFilter
    {
        $this->startDateFrom = $startDateFrom;
        return $this;
    }

    public function getStartDateTo(): ?\DateTime
    {
        return $this->startDateTo;
    }

    public function setStartDateTo(?\DateTime $startDateTo): CouponGroupFilter
    {
        $this->startDateTo = $startDateTo;
        return $this;
    }

    public function getEndDateFrom(): ?\DateTime
    {
        return $this->endDateFrom;
    }

    public function setEndDateFrom(?\DateTime $endDateFrom): CouponGroupFilter
    {
        $this->endDateFrom = $endDateFrom;
        return $this;
    }

    public function getEndDateTo(): ?\DateTime
    {
        return $this->endDateTo;
    }

    public function setEndDateTo(?\DateTime $endDateTo): CouponGroupFilter
    {
        $this->endDateTo = $endDateTo;
        return $this;
    }

    public function getParentId(): ?CouponGroupId
    {
        return $this->parentId;
    }

    public function setParentId(?CouponGroupId $parentId): CouponGroupFilter
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function getNameFilter(): string
    {
        return $this->nameFilter;
    }

    public function setNameFilter(string $nameFilter): CouponGroupFilter
    {
        $this->nameFilter = $nameFilter;
        return $this;
    }

    public function isShowDeleted(): bool
    {
        return $this->showDeleted;
    }

    public function setShowDeleted(bool $showDeleted): CouponGroupFilter
    {
        $this->showDeleted = $showDeleted;
        return $this;
    }
}
