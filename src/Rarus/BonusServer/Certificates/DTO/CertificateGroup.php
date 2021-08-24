<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\DTO;


use Rarus\BonusServer\Certificates\DTO\ExcludeShopItems\ExcludeShopItemCollection;
use Rarus\BonusServer\Certificates\DTO\IncludeShopItems\IncludeShopItemCollection;

/**
 * Class CertificateGroup
 *
 * @package Rarus\BonusServer\Certificates\DTO
 */
class CertificateGroup
{
    /**
     * @var int
     */
    private $rowNumber;

    /**
     * @var \Rarus\BonusServer\Certificates\DTO\CertificateGroupId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var \DateTime|null
     */
    private $startDate;

    /**
     * @var \DateTime|null
     */
    private $endDate;

    /**
     * @var \DateTime|null
     */
    private $startSaleDate;

    /**
     * @var \DateTime|null
     */
    private $endSaleDate;

    /**
     * @var int
     */
    private $periodType;

    /**
     * @var int|null
     */
    private $useDays;

    /**
     * @var double|int
     */
    private $value;

    /**
     * @var int|null
     */
    private $useMethod;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @var IncludeShopItemCollection|null
     */
    private $includeShopItems;

    /**
     * @var ExcludeShopItemCollection|null
     */
    private $excludeShopItems;

    /**
     * @param int $rowNumber
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setRowNumber(int $rowNumber): self
    {
        $this->rowNumber = $rowNumber;

        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\CertificateGroupId $id
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setId(CertificateGroupId $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setEndDate(\DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @param \DateTime $startSaleDate
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setStartSaleDate(\DateTime $startSaleDate): self
    {
        $this->startSaleDate = $startSaleDate;

        return $this;
    }

    /**
     * @param \DateTime $endSaleDate
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setEndSaleDate(\DateTime $endSaleDate): self
    {
        $this->endSaleDate = $endSaleDate;

        return $this;
    }

    /**
     * @param int $periodType
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setPeriodType(int $periodType): self
    {
        $this->periodType = $periodType;

        return $this;
    }

    /**
     * @param int|null $useDays
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setUseDays(?int $useDays): self
    {
        $this->useDays = $useDays;

        return $this;
    }

    /**
     * @param float|int $value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param int $useMethod
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setUseMethod(int $useMethod): self
    {
        $this->useMethod = $useMethod;

        return $this;
    }

    /**
     * @param bool $deleted
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\IncludeShopItems\IncludeShopItemCollection|null $includeShopItems
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setIncludeShopItems(?IncludeShopItemCollection $includeShopItems): self
    {
        $this->includeShopItems = $includeShopItems;

        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\ExcludeShopItems\ExcludeShopItemCollection|null $excludeShopItems
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public function setExcludeShopItems(?ExcludeShopItemCollection $excludeShopItems): self
    {
        $this->excludeShopItems = $excludeShopItems;

        return $this;
    }

    /**
     * @return int
     */
    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }

    /**
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroupId
     */
    public function getCertificateGroupId(): CertificateGroupId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
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
     * @return \DateTime|null
     */
    public function getStartSaleDate(): ?\DateTime
    {
        return $this->startSaleDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndSaleDate(): ?\DateTime
    {
        return $this->endSaleDate;
    }

    /**
     * @return int
     */
    public function getPeriodType(): int
    {
        return $this->periodType;
    }

    /**
     * @return int|null
     */
    public function getUseDays(): ?int
    {
        return $this->useDays;
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int|null
     */
    public function getUseMethod(): ?int
    {
        return $this->useMethod;
    }

    /**
     * @return bool|null
     */
    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    /**
     * @return IncludeShopItemCollection|null
     */
    public function getIncludeShopItems(): ?IncludeShopItemCollection
    {
        return $this->includeShopItems;
    }

    /**
     * @return ExcludeShopItemCollection|null
     */
    public function getExcludeShopItems(): ?ExcludeShopItemCollection
    {
        return $this->excludeShopItems;
    }
}
