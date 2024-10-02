<?php

declare(strict_types=1);


namespace Rarus\BonusServer\CouponHolds\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Coupons\DTO\CouponId;

/**
 * Class Coupon
 *
 * @package Rarus\BonusServer\Coupons\DTO
 */
class NewCouponHold
{
    /**
     * @var CouponHoldId
     */
    private $id;

    /**
     * @var CouponId
     */
    private $couponId;

    /**
     * @var CardId
     */
    private $cardId;

    /**
     * @var string
     */
    private $comment = '';

    /**
     * @var \DateTime | null
     */
    private $dateTo;

    /**
     * @var int | null
     */
    private $duration;

    /**
     * @param CouponHoldId $id
     */
    public function __construct(CouponHoldId $id)
    {
        $this->id = $id;
    }

    public function getId(): CouponHoldId
    {
        return $this->id;
    }

    public function setId(CouponHoldId $id): NewCouponHold
    {
        $this->id = $id;
        return $this;
    }

    public function getCouponId(): CouponId
    {
        return $this->couponId;
    }

    public function setCouponId(CouponId $couponId): NewCouponHold
    {
        $this->couponId = $couponId;
        return $this;
    }

    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    public function setCardId(CardId $cardId): NewCouponHold
    {
        $this->cardId = $cardId;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): NewCouponHold
    {
        $this->comment = $comment;
        return $this;
    }

    public function getDateTo(): ?\DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(?\DateTime $dateTo): NewCouponHold
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): NewCouponHold
    {
        $this->duration = $duration;
        return $this;
    }
}
