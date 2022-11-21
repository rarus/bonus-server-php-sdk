<?php

namespace Rarus\BonusServer\Promotions\DTO;

class PromotionFilter
{
    /**
     * @var \DateTime|null
     */
    private $from;
    /**
     * @var \DateTime|null
     */
    private $to;
    /**
     * @var \Rarus\BonusServer\Shops\DTO\ShopId|null
     */
    private $shopId;
    /**
     * @var bool
     */
    private $withFullDescription = true;

    /**
     * @param \DateTime|null $from
     *
     * @return PromotionFilter
     */
    public function setFrom(?\DateTime $from): PromotionFilter
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param \DateTime|null $to
     *
     * @return PromotionFilter
     */
    public function setTo(?\DateTime $to): PromotionFilter
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Shops\DTO\ShopId|null $shopId
     *
     * @return PromotionFilter
     */
    public function setShopId(?\Rarus\BonusServer\Shops\DTO\ShopId $shopId): PromotionFilter
    {
        $this->shopId = $shopId;
        return $this;
    }

    /**
     * @param bool $withFullDescription
     *
     * @return PromotionFilter
     */
    public function setWithFullDescription(bool $withFullDescription): PromotionFilter
    {
        $this->withFullDescription = $withFullDescription;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getFrom(): ?\DateTime
    {
        return $this->from;
    }

    /**
     * @return \DateTime|null
     */
    public function getTo(): ?\DateTime
    {
        return $this->to;
    }

    /**
     * @return \Rarus\BonusServer\Shops\DTO\ShopId|null
     */
    public function getShopId(): ?\Rarus\BonusServer\Shops\DTO\ShopId
    {
        return $this->shopId;
    }

    /**
     * @return bool
     */
    public function isWithFullDescription(): bool
    {
        return $this->withFullDescription;
    }
}