<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Coupons\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;

/**
 * Class Coupon
 *
 * @package Rarus\BonusServer\Coupons\DTO
 */
class Coupon
{
    /**
     * @var CouponId
     */
    private $id;
    /**
     * @var bool|null
     */
    private $active;
    /**
     * @var CardId|null
     */
    private $cardId;
    /**
     * @var int|null
     */
    private $used;
    /**
     * @var \DateTime|null
     */
    private $addDate;
    /**
     * @var \DateTime|null
     */
    private $activateDate;
    /**
     * @var \DateTime|null
     */
    private $lastDate;

    /**
     * Coupon constructor.
     *
     * @param CouponId $id
     */
    public function __construct(CouponId $id)
    {
        $this->id = $id;
    }

    /**
     * @return CouponId
     */
    public function getId(): CouponId
    {
        return $this->id;
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
     */
    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return CardId|null
     */
    public function getCardId(): ?CardId
    {
        return $this->cardId;
    }

    /**
     * @param CardId|null $cardId
     */
    public function setCardId(?CardId $cardId): self
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUsed(): ?int
    {
        return $this->used;
    }

    /**
     * @param int|null $used
     */
    public function setUsed(?int $used): self
    {
        $this->used = $used;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getAddDate(): ?\DateTime
    {
        return $this->addDate;
    }

    /**
     * @param \DateTime|null $addDate
     */
    public function setAddDate(?\DateTime $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getActivateDate(): ?\DateTime
    {
        return $this->activateDate;
    }

    /**
     * @param \DateTime|null $activateDate
     */
    public function setActivateDate(?\DateTime $activateDate): self
    {
        $this->activateDate = $activateDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastDate(): ?\DateTime
    {
        return $this->lastDate;
    }

    /**
     * @param \DateTime|null $lastDate
     */
    public function setLastDate(?\DateTime $lastDate): self
    {
        $this->lastDate = $lastDate;

        return $this;
    }
}
