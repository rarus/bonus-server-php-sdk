<?php

declare(strict_types=1);

namespace Rarus\BonusServer\DiscountConditions\DTO;

final class DiscountCondition
{
    /** @var int */
    private $row_number;

    /** @var string */
    private $id;

    /** @var string */
    private $discount_id;

    /** @var int */
    private $type;

    /** @var int */
    private $region;

    /** @var int */
    private $condition;

    /** @var int */
    private $value;

    /** @var string|null */
    private $segment_id;

    /** @var string|null */
    private $prefix_code;

    /** @var string|null */
    private $prefix_barcode;

    /** @var string */
    private $description;

    /** @var int */
    private $sort;

    /** @var string|null */
    private $assortment_group_id;

    /**
     * @var array|null
     */
    private $hours;

    /**
     * @return int
     */
    public function getRowNumber(): int
    {
        return $this->row_number;
    }

    /**
     * @param int $row_number
     * @return DiscountCondition
     */
    public function setRowNumber(int $row_number): DiscountCondition
    {
        $this->row_number = $row_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return DiscountCondition
     */
    public function setId(string $id): DiscountCondition
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountId(): string
    {
        return $this->discount_id;
    }

    /**
     * @param string $discount_id
     * @return DiscountCondition
     */
    public function setDiscountId(string $discount_id): DiscountCondition
    {
        $this->discount_id = $discount_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return DiscountCondition
     */
    public function setType(int $type): DiscountCondition
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getRegion(): int
    {
        return $this->region;
    }

    /**
     * @param int $region
     * @return DiscountCondition
     */
    public function setRegion(int $region): DiscountCondition
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return int
     */
    public function getCondition(): int
    {
        return $this->condition;
    }

    /**
     * @param int $condition
     * @return DiscountCondition
     */
    public function setCondition(int $condition): DiscountCondition
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return DiscountCondition
     */
    public function setValue(int $value): DiscountCondition
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSegmentId(): ?string
    {
        return $this->segment_id;
    }

    /**
     * @param string|null $segment_id
     * @return DiscountCondition
     */
    public function setSegmentId(?string $segment_id): DiscountCondition
    {
        $this->segment_id = $segment_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrefixCode(): ?string
    {
        return $this->prefix_code;
    }

    /**
     * @param string|null $prefix_code
     * @return DiscountCondition
     */
    public function setPrefixCode(?string $prefix_code): DiscountCondition
    {
        $this->prefix_code = $prefix_code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrefixBarcode(): ?string
    {
        return $this->prefix_barcode;
    }

    /**
     * @param string|null $prefix_barcode
     * @return DiscountCondition
     */
    public function setPrefixBarcode(?string $prefix_barcode): DiscountCondition
    {
        $this->prefix_barcode = $prefix_barcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return DiscountCondition
     */
    public function setDescription(string $description): DiscountCondition
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     * @return DiscountCondition
     */
    public function setSort(int $sort): DiscountCondition
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAssortmentGroupId(): ?string
    {
        return $this->assortment_group_id;
    }

    /**
     * @param string|null $assortment_group_id
     * @return DiscountCondition
     */
    public function setAssortmentGroupId(?string $assortment_group_id): DiscountCondition
    {
        $this->assortment_group_id = $assortment_group_id;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHours(): ?array
    {
        return $this->hours;
    }

    /**
     * @param array|null $hours
     * @return DiscountCondition
     */
    public function setHours(?array $hours): DiscountCondition
    {
        $this->hours = $hours;
        return $this;
    }
}
