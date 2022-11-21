<?php

namespace Rarus\BonusServer\Promotions\DTO;

use Rarus\BonusServer\Transport\DTO\PropertyCollection;

final class Promotion
{
    /**
     * @var \Rarus\BonusServer\Promotions\DTO\PromotionId
     */
    private $id;
    /**
     * @var \DateTime|null
     */
    private $startDate;
    /**
     * @var \DateTime|null
     */
    private $endDate;
    /**
     * @var \Rarus\BonusServer\Shops\DTO\ShopId|null
     */
    private $shopId;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var string|null
     */
    private $shortDescription;
    /**
     * @var string|null
     */
    private $fullDescription;
    /**
     * @var string|null
     */
    private $promoUrl;
    /**
     * @var int
     */
    private $textType = 0;
    /**
     * @var int
     */
    private $priority = 0;
    /**
     * @var string|null
     */
    private $image;
    /**
     * @var \Rarus\BonusServer\Transport\DTO\PropertyCollection|null
     */
    private $propertyCollection;

    /**
     * @param \Rarus\BonusServer\Promotions\DTO\PromotionId $id
     */
    public function __construct(PromotionId $id)
    {
        $this->id = $id;
    }

    /**
     * @param \DateTime|null $startDate
     *
     * @return Promotion
     */
    public function setStartDate(?\DateTime $startDate): Promotion
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @param \DateTime|null $endDate
     *
     * @return Promotion
     */
    public function setEndDate(?\DateTime $endDate): Promotion
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Shops\DTO\ShopId|null $shopId
     *
     * @return Promotion
     */
    public function setShopId(?\Rarus\BonusServer\Shops\DTO\ShopId $shopId): Promotion
    {
        $this->shopId = $shopId;
        return $this;
    }

    /**
     * @param string|null $name
     *
     * @return Promotion
     */
    public function setName(?string $name): Promotion
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string|null $shortDescription
     *
     * @return Promotion
     */
    public function setShortDescription(?string $shortDescription): Promotion
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @param string|null $fullDescription
     *
     * @return Promotion
     */
    public function setFullDescription(?string $fullDescription): Promotion
    {
        $this->fullDescription = $fullDescription;
        return $this;
    }

    /**
     * @param string|null $promoUrl
     *
     * @return Promotion
     */
    public function setPromoUrl(?string $promoUrl): Promotion
    {
        $this->promoUrl = $promoUrl;
        return $this;
    }

    /**
     * @param int $textType
     *
     * @return Promotion
     */
    public function setTextType(int $textType): Promotion
    {
        $this->textType = $textType;
        return $this;
    }

    /**
     * @param int $priority
     *
     * @return Promotion
     */
    public function setPriority(int $priority): Promotion
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param string|null $image
     *
     * @return Promotion
     */
    public function setImage(?string $image): Promotion
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Transport\DTO\PropertyCollection|null $propertyCollection
     *
     * @return Promotion
     */
    public function setPropertyCollection(?PropertyCollection $propertyCollection
    ): Promotion {
        $this->propertyCollection = $propertyCollection;
        return $this;
    }

    /**
     * @return \Rarus\BonusServer\Promotions\DTO\PromotionId
     */
    public function getPromotionId(): PromotionId
    {
        return $this->id;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @return \Rarus\BonusServer\Shops\DTO\ShopId|null
     */
    public function getShopId(): ?\Rarus\BonusServer\Shops\DTO\ShopId
    {
        return $this->shopId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @return string|null
     */
    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    /**
     * @return string|null
     */
    public function getPromoUrl(): ?string
    {
        return $this->promoUrl;
    }

    /**
     * @return int
     */
    public function getTextType(): int
    {
        return $this->textType;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return \Rarus\BonusServer\Transport\DTO\PropertyCollection|null
     */
    public function getPropertyCollection(): ?PropertyCollection
    {
        return $this->propertyCollection;
    }
}