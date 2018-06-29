<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO\DiscountItems;

use Money\Money;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Segments\DTO\SegmentId;

/**
 * Class DiscountItem
 *
 * @package Rarus\BonusServer\Discounts\DTO\DiscountItems
 */
final class DiscountItem
{
    /**
     * @var int
     */
    private $lineNumber;
    /**
     * @var DiscountId
     */
    private $discountId;
    /**
     * @var int
     */
    private $typeId;
    /**
     * @var Money
     */
    private $sum;
    /**
     * @var SegmentId|null
     */
    private $giftSegment;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int|null Значение указанное при настройке скидки. Зависит от вида скидки. Информативное поле.
     */
    private $value;

    /**
     * @return int
     */
    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     *
     * @return DiscountItem
     */
    public function setLineNumber(int $lineNumber): DiscountItem
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    /**
     * @return DiscountId
     */
    public function getDiscountId(): DiscountId
    {
        return $this->discountId;
    }

    /**
     * @param DiscountId $discountId
     *
     * @return DiscountItem
     */
    public function setDiscountId(DiscountId $discountId): DiscountItem
    {
        $this->discountId = $discountId;

        return $this;
    }

    /**
     * @return int
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     *
     * @return DiscountItem
     */
    public function setTypeId(int $typeId): DiscountItem
    {
        $this->typeId = $typeId;

        return $this;
    }

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
     * @return DiscountItem
     */
    public function setSum(Money $sum): DiscountItem
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return null|SegmentId
     */
    public function getGiftSegment(): ?SegmentId
    {
        return $this->giftSegment;
    }

    /**
     * @param null|SegmentId $giftSegment
     *
     * @return DiscountItem
     */
    public function setGiftSegment(?SegmentId $giftSegment): DiscountItem
    {
        $this->giftSegment = $giftSegment;

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
     *
     * @return DiscountItem
     */
    public function setName(string $name): DiscountItem
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param int|null $value
     *
     * @return DiscountItem
     */
    public function setValue(?int $value): DiscountItem
    {
        $this->value = $value;

        return $this;
    }
}