<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Products;

use Money\Money;
use Rarus\BonusServer\Articles\DTO\ArticleId;

/**
 * Class ProductRow
 *
 * @package Rarus\BonusServer\Transactions\DTO\Products
 */
final class ProductRow
{
    /**
     * @var ArticleId
     */
    private $articleId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $quantity;
    /**
     * @var Money
     */
    private $price;
    /**
     * @var Money
     */
    private $discount;

    /**
     * @return ArticleId
     */
    public function getArticleId(): ArticleId
    {
        return $this->articleId;
    }

    /**
     * @param ArticleId $articleId
     *
     * @return ProductRow
     */
    public function setArticleId(ArticleId $articleId): ProductRow
    {
        $this->articleId = $articleId;

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
     * @return ProductRow
     */
    public function setName(string $name): ProductRow
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return ProductRow
     */
    public function setQuantity(int $quantity): ProductRow
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @param Money $price
     *
     * @return ProductRow
     */
    public function setPrice(Money $price): ProductRow
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Money
     */
    public function getDiscount(): Money
    {
        return $this->discount;
    }

    /**
     * @param Money $discount
     *
     * @return ProductRow
     */
    public function setDiscount(Money $discount): ProductRow
    {
        $this->discount = $discount;

        return $this;
    }
}
