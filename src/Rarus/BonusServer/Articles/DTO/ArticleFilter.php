<?php


namespace Rarus\BonusServer\Articles\DTO;

use Rarus\BonusServer\Articles\DTO\Property\ArticleProperty;
use Rarus\BonusServer\Articles\DTO\Property\ArticlePropertyId;

/**
 * Class ArticleFilter
 *
 * @package Rarus\BonusServer\Articles\DTO
 */
class ArticleFilter
{
    /**
     * @var ArticleId|null
     */
    private $id;
    /**
     * @var bool|null
     */
    private $deleted;
    /**
     * @var ArticleId|null
     */
    private $parentId;
    /**
     * @var string|null
     */
    private $nameFilter;
    /**
     * @var bool|null
     */
    private $withGroups;
    /**
     * @var ArticlePropertyId
     */
    private $propertyId;
    /**
     * @var ArticleProperty
     */
    private $propertyValue;

    /**
     * @return ArticleId|null
     */
    public function getArticleId(): ?ArticleId
    {
        return $this->id;
    }

    /**
     * @param ArticleId|null $id
     */
    public function setArticleId(?ArticleId $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool|null
     */
    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    /**
     * @param bool|null $deleted
     */
    public function setDeleted(?bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return ArticleId|null
     */
    public function getParentId(): ?ArticleId
    {
        return $this->parentId;
    }

    /**
     * @param ArticleId|null $parentId
     */
    public function setParentId(?ArticleId $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string|null
     */
    public function getNameFilter(): ?string
    {
        return $this->nameFilter;
    }

    /**
     * @param string|null $nameFilter
     */
    public function setNameFilter(?string $nameFilter): void
    {
        $this->nameFilter = $nameFilter;
    }

    /**
     * @return bool|null
     */
    public function getWithGroups(): ?bool
    {
        return $this->withGroups;
    }

    /**
     * @param bool|null $withGroups
     */
    public function setWithGroups(?bool $withGroups): void
    {
        $this->withGroups = $withGroups;
    }

    /**
     * @return ArticlePropertyId|null
     */
    public function getPropertyId(): ?ArticlePropertyId
    {
        return $this->propertyId;
    }

    /**
     * @param ArticlePropertyId $propertyId
     */
    public function setPropertyId(ArticlePropertyId $propertyId): void
    {
        $this->propertyId = $propertyId;
    }

    /**
     * @return ArticleProperty|null
     */
    public function getPropertyValue(): ?ArticleProperty
    {
        return $this->propertyValue;
    }

    /**
     * @param ArticleProperty $propertyValue
     */
    public function setPropertyValue(ArticleProperty $propertyValue): void
    {
        $this->propertyValue = $propertyValue;
    }
}
