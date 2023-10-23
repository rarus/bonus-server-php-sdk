<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

final class Discount
{
    /** @var int */
    public $row_number;

    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var bool */
    public $active;

    /** @var string */
    public $group_id;

    /** @var int */
    public $type;

    /** @var int */
    public $start_date;

    /** @var int */
    public $end_date;

    /** @var int */
    public $value;

    /** @var int */
    public $apply_to;

    /** @var string */
    public $included_articles;

    /** @var string */
    public $exclude_articles;

    /** @var string */
    public $gift_articles;

    /** @var int */
    public $priority;

    /** @var bool */
    public $deleted;

    /** @var int */
    public $invalidate_period;

    /** @var int */
    public $activation_period;

    /** @var bool */
    public $once;

    /** @var int */
    public $once_period;

    /** @var bool */
    public $restrict_all_group;

    /** @var int */
    public $base_date;

    /** @var bool */
    public $multiply_by_conditions;

    /** @var bool */
    public $isbonus;

    /** @var string */
    public $function;

    /** @var int */
    public $invalidate_date;

    /** @var int */
    public $activation_date;

    /** @var bool */
    public $applicable_to_external_discounts;

    /** @var bool */
    public $for_referral;

    /** @var bool */
    public $exclude_from_accumulation;

    /** @var bool */
    public $value_from_cheque_field;

    /** @var string */
    public $cheque_field;

    /** @var bool */
    public $upload_to_bitrix24;

    /** @var bool */
    public $ismanual;

    /** @var array | null */
    public $exclude_article_items;

    /** @var array | null */
    public $include_article_items;

    /** @var array | null */
    public $discount_shops;

    /**
     * @return int
     */
    public function getRowNumber(): int
    {
        return $this->row_number;
    }

    /**
     * @param int $row_number
     * @return Discount
     */
    public function setRowNumber(int $row_number): Discount
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
     * @return Discount
     */
    public function setId(string $id): Discount
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Discount
     */
    public function setName(string $name): Discount
    {
        $this->name = $name;
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
     * @return Discount
     */
    public function setDescription(string $description): Discount
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Discount
     */
    public function setActive(bool $active): Discount
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->group_id;
    }

    /**
     * @param string $group_id
     * @return Discount
     */
    public function setGroupId(string $group_id): Discount
    {
        $this->group_id = $group_id;
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
     * @return Discount
     */
    public function setType(int $type): Discount
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getStartDate(): int
    {
        return $this->start_date;
    }

    /**
     * @param int $start_date
     * @return Discount
     */
    public function setStartDate(int $start_date): Discount
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * @return int
     */
    public function getEndDate(): int
    {
        return $this->end_date;
    }

    /**
     * @param int $end_date
     * @return Discount
     */
    public function setEndDate(int $end_date): Discount
    {
        $this->end_date = $end_date;
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
     * @return Discount
     */
    public function setValue(int $value): Discount
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getApplyTo(): int
    {
        return $this->apply_to;
    }

    /**
     * @param int $apply_to
     * @return Discount
     */
    public function setApplyTo(int $apply_to): Discount
    {
        $this->apply_to = $apply_to;
        return $this;
    }

    /**
     * @return string
     */
    public function getIncludedArticles(): string
    {
        return $this->included_articles;
    }

    /**
     * @param string $included_articles
     * @return Discount
     */
    public function setIncludedArticles(string $included_articles): Discount
    {
        $this->included_articles = $included_articles;
        return $this;
    }

    /**
     * @return string
     */
    public function getExcludeArticles(): string
    {
        return $this->exclude_articles;
    }

    /**
     * @param string $exclude_articles
     * @return Discount
     */
    public function setExcludeArticles(string $exclude_articles): Discount
    {
        $this->exclude_articles = $exclude_articles;
        return $this;
    }

    /**
     * @return string
     */
    public function getGiftArticles(): string
    {
        return $this->gift_articles;
    }

    /**
     * @param string $gift_articles
     * @return Discount
     */
    public function setGiftArticles(string $gift_articles): Discount
    {
        $this->gift_articles = $gift_articles;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return Discount
     */
    public function setPriority(int $priority): Discount
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return Discount
     */
    public function setDeleted(bool $deleted): Discount
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return int
     */
    public function getInvalidatePeriod(): int
    {
        return $this->invalidate_period;
    }

    /**
     * @param int $invalidate_period
     * @return Discount
     */
    public function setInvalidatePeriod(int $invalidate_period): Discount
    {
        $this->invalidate_period = $invalidate_period;
        return $this;
    }

    /**
     * @return int
     */
    public function getActivationPeriod(): int
    {
        return $this->activation_period;
    }

    /**
     * @param int $activation_period
     * @return Discount
     */
    public function setActivationPeriod(int $activation_period): Discount
    {
        $this->activation_period = $activation_period;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOnce(): bool
    {
        return $this->once;
    }

    /**
     * @param bool $once
     * @return Discount
     */
    public function setOnce(bool $once): Discount
    {
        $this->once = $once;
        return $this;
    }

    /**
     * @return int
     */
    public function getOncePeriod(): int
    {
        return $this->once_period;
    }

    /**
     * @param int $once_period
     * @return Discount
     */
    public function setOncePeriod(int $once_period): Discount
    {
        $this->once_period = $once_period;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRestrictAllGroup(): bool
    {
        return $this->restrict_all_group;
    }

    /**
     * @param bool $restrict_all_group
     * @return Discount
     */
    public function setRestrictAllGroup(bool $restrict_all_group): Discount
    {
        $this->restrict_all_group = $restrict_all_group;
        return $this;
    }

    /**
     * @return int
     */
    public function getBaseDate(): int
    {
        return $this->base_date;
    }

    /**
     * @param int $base_date
     * @return Discount
     */
    public function setBaseDate(int $base_date): Discount
    {
        $this->base_date = $base_date;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiplyByConditions(): bool
    {
        return $this->multiply_by_conditions;
    }

    /**
     * @param bool $multiply_by_conditions
     * @return Discount
     */
    public function setMultiplyByConditions(bool $multiply_by_conditions): Discount
    {
        $this->multiply_by_conditions = $multiply_by_conditions;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsbonus(): bool
    {
        return $this->isbonus;
    }

    /**
     * @param bool $isbonus
     * @return Discount
     */
    public function setIsbonus(bool $isbonus): Discount
    {
        $this->isbonus = $isbonus;
        return $this;
    }

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @param string $function
     * @return Discount
     */
    public function setFunction(string $function): Discount
    {
        $this->function = $function;
        return $this;
    }

    /**
     * @return int
     */
    public function getInvalidateDate(): int
    {
        return $this->invalidate_date;
    }

    /**
     * @param int $invalidate_date
     * @return Discount
     */
    public function setInvalidateDate(int $invalidate_date): Discount
    {
        $this->invalidate_date = $invalidate_date;
        return $this;
    }

    /**
     * @return int
     */
    public function getActivationDate(): int
    {
        return $this->activation_date;
    }

    /**
     * @param int $activation_date
     * @return Discount
     */
    public function setActivationDate(int $activation_date): Discount
    {
        $this->activation_date = $activation_date;
        return $this;
    }

    /**
     * @return bool
     */
    public function isApplicableToExternalDiscounts(): bool
    {
        return $this->applicable_to_external_discounts;
    }

    /**
     * @param bool $applicable_to_external_discounts
     * @return Discount
     */
    public function setApplicableToExternalDiscounts(bool $applicable_to_external_discounts): Discount
    {
        $this->applicable_to_external_discounts = $applicable_to_external_discounts;
        return $this;
    }

    /**
     * @return bool
     */
    public function isForReferral(): bool
    {
        return $this->for_referral;
    }

    /**
     * @param bool $for_referral
     * @return Discount
     */
    public function setForReferral(bool $for_referral): Discount
    {
        $this->for_referral = $for_referral;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExcludeFromAccumulation(): bool
    {
        return $this->exclude_from_accumulation;
    }

    /**
     * @param bool $exclude_from_accumulation
     * @return Discount
     */
    public function setExcludeFromAccumulation(bool $exclude_from_accumulation): Discount
    {
        $this->exclude_from_accumulation = $exclude_from_accumulation;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValueFromChequeField(): bool
    {
        return $this->value_from_cheque_field;
    }

    /**
     * @param bool $value_from_cheque_field
     * @return Discount
     */
    public function setValueFromChequeField(bool $value_from_cheque_field): Discount
    {
        $this->value_from_cheque_field = $value_from_cheque_field;
        return $this;
    }

    /**
     * @return string
     */
    public function getChequeField(): string
    {
        return $this->cheque_field;
    }

    /**
     * @param string $cheque_field
     * @return Discount
     */
    public function setChequeField(string $cheque_field): Discount
    {
        $this->cheque_field = $cheque_field;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUploadToBitrix24(): bool
    {
        return $this->upload_to_bitrix24;
    }

    /**
     * @param bool $upload_to_bitrix24
     * @return Discount
     */
    public function setUploadToBitrix24(bool $upload_to_bitrix24): Discount
    {
        $this->upload_to_bitrix24 = $upload_to_bitrix24;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsmanual(): bool
    {
        return $this->ismanual;
    }

    /**
     * @param bool $ismanual
     * @return Discount
     */
    public function setIsmanual(bool $ismanual): Discount
    {
        $this->ismanual = $ismanual;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getExcludeArticleItems(): ?array
    {
        return $this->exclude_article_items;
    }

    /**
     * @param array|null $exclude_article_items
     * @return Discount
     */
    public function setExcludeArticleItems(?array $exclude_article_items): Discount
    {
        $this->exclude_article_items = $exclude_article_items;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getIncludeArticleItems(): ?array
    {
        return $this->include_article_items;
    }

    /**
     * @param array|null $include_article_items
     * @return Discount
     */
    public function setIncludeArticleItems(?array $include_article_items): Discount
    {
        $this->include_article_items = $include_article_items;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getDiscountShops(): ?array
    {
        return $this->discount_shops;
    }

    /**
     * @param array|null $discount_shops
     * @return Discount
     */
    public function setDiscountShops(?array $discount_shops): Discount
    {
        $this->discount_shops = $discount_shops;
        return $this;
    }
}
