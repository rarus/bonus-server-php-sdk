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
class CouponHold
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
     * @var \DateTime
     */
    private $addDate;

    /**
     * @var \DateTime
     */
    private $dateTo;

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

    public function getCouponId(): CouponId
    {
        return $this->couponId;
    }

    public function setCouponId(CouponId $couponId): CouponHold
    {
        $this->couponId = $couponId;
        return $this;
    }

    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    public function setCardId(CardId $cardId): CouponHold
    {
        $this->cardId = $cardId;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): CouponHold
    {
        $this->comment = $comment;
        return $this;
    }

    public function getAddDate(): \DateTime
    {
        return $this->addDate;
    }

    public function setAddDate(\DateTime $addDate): CouponHold
    {
        $this->addDate = $addDate;
        return $this;
    }

    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTime $dateTo): CouponHold
    {
        $this->dateTo = $dateTo;
        return $this;
    }
}
