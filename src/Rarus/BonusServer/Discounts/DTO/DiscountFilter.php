<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use DateTime;
use Rarus\BonusServer\Shops\DTO\ShopId;

final class DiscountFilter
{
    /**
     * @var string|null
     */
    private $groupId;
    /**
     * @var DateTime|null
     */
    private $dateFrom;
    /**
     * @var DateTime|null
     */
    private $dateTo;
    /**
     * @var ShopId
     */
    private $shopId;
    /**
     * @var bool|null
     */
    private $showDeleted;
    /**
     * @var bool|null
     */
    private $shopAll;
    /**
     * @var bool|null
     */
    private $fullInfo;
    /**
     * @var string|null
     */
    private $function;
    /**
     * @var bool|null
     */
    private $uploadToBitrix;
    /**
     * @var bool|null
     */
    private $isManual;

    /**
     * @return string|null
     */
    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    /**
     * @param string|null $groupId
     */
    public function setGroupId(?string $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateFrom(): ?DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTime|null $dateFrom
     */
    public function setDateFrom(?DateTime $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateTo(): ?DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param DateTime|null $dateTo
     */
    public function setDateTo(?DateTime $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * @return ShopId|null
     */
    public function getShopId(): ?ShopId
    {
        return $this->shopId;
    }

    /**
     * @param ShopId $shopId
     * @return $this
     */
    public function setShopId(ShopId $shopId): self
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShowDeleted(): ?bool
    {
        return $this->showDeleted;
    }

    /**
     * @param bool|null $showDeleted
     */
    public function setShowDeleted(?bool $showDeleted): self
    {
        $this->showDeleted = $showDeleted;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShopAll(): ?bool
    {
        return $this->shopAll;
    }

    /**
     * @param bool|null $shopAll
     */
    public function setShopAll(?bool $shopAll): self
    {
        $this->shopAll = $shopAll;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getFullInfo(): ?bool
    {
        return $this->fullInfo;
    }

    /**
     * @param bool|null $fullInfo
     */
    public function setFullInfo(?bool $fullInfo): self
    {
        $this->fullInfo = $fullInfo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFunction(): ?string
    {
        return $this->function;
    }

    /**
     * @param string|null $function
     */
    public function setFunction(?string $function): self
    {
        $this->function = $function;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getUploadToBitrix(): ?bool
    {
        return $this->uploadToBitrix;
    }

    /**
     * @param bool|null $uploadToBitrix
     * @return DiscountFilter
     */
    public function setUploadToBitrix(?bool $uploadToBitrix): self
    {
        $this->uploadToBitrix = $uploadToBitrix;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsManual(): ?bool
    {
        return $this->isManual;
    }

    /**
     * @param bool|null $isManual
     * @return DiscountFilter
     */
    public function setIsManual(?bool $isManual): self
    {
        $this->isManual = $isManual;

        return $this;
    }
}
