<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Articles\DTO;

use Rarus\BonusServer\Articles\DTO\Property\ArticlePropertyCollection;

/**
 * Class Article
 *
 * @package Rarus\BonusServer\Articles\DTO
 */
class Article
{
    /**
     * @var ArticleId Идентификатор ассортимента
     */
    private $articleId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var ArticleId Идентификатор родительской группы. Если не передан - ассортимент создается в корне дерева
     */
    private $parentId;
    /**
     * @var string
     */
    private $description;
    /**
     * @var bool
     */
    private $isGroup;
    /**
     * @var bool
     */
    private $uploadMobile;
    /**
     * @var bool
     */
    private $deleted;
    /**
     * @var ArticlePropertyCollection|null
     */
    private $propertyCollection;
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var string
     */
    private $image;

    /**
     * Article constructor.
     *
     * @param ArticleId $articleId
     * @param string    $name
     */
    public function __construct(ArticleId $articleId, string $name)
    {
        $this->articleId = $articleId;
        $this->name = $name;
    }


    /**
     * @return ArticleId
     */
    public function getArticleId(): ArticleId
    {
        return $this->articleId;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return ArticleId|null
     */
    public function getParentId(): ?ArticleId
    {
        return $this->parentId;
    }

    /**
     * @param ArticleId $parentId
     */
    public function setParentId(ArticleId $parentId): Article
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return \Rarus\BonusServer\Articles\DTO\Article
     */
    public function setDescription(string $description): Article
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isGroup(): ?bool
    {
        return $this->isGroup;
    }

    /**
     * @param bool $isGroup
     *
     * @return \Rarus\BonusServer\Articles\DTO\Article
     */
    public function setIsGroup(bool $isGroup): Article
    {
        $this->isGroup = $isGroup;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isUploadMobile(): ?bool
    {
        return $this->uploadMobile;
    }

    /**
     * @param bool $uploadMobile
     *
     * @return \Rarus\BonusServer\Articles\DTO\Article
     */
    public function setUploadMobile(bool $uploadMobile): Article
    {
        $this->uploadMobile = $uploadMobile;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     *
     * @return \Rarus\BonusServer\Articles\DTO\Article
     */
    public function setDeleted(bool $deleted): Article
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return ArticlePropertyCollection
     */
    public function getPropertyCollection(): ArticlePropertyCollection
    {
        return $this->propertyCollection ?? new ArticlePropertyCollection();
    }

    /**
     * @param ArticlePropertyCollection $propertyCollection
     *
     * @return \Rarus\BonusServer\Articles\DTO\Article
     */
    public function setPropertyCollection(ArticlePropertyCollection $propertyCollection): Article
    {
        $this->propertyCollection = $propertyCollection;

        return $this;
    }

    public function setDate(\DateTime $articleDate): Article
    {
        $this->date = $articleDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setImage(string $imageUrl): Article
    {
        $this->image = $imageUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

}
