<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO\DocumentItems;

use Money\Money;
use Rarus\BonusServer\Articles\DTO\ArticleId;
use Rarus\BonusServer\Discounts\DTO\Bonuses\Bonus;

/**
 * Class ChequeRow
 *
 * @package Rarus\BonusServer\Discounts\DTO\DocumentItems
 */
final class DocumentItem
{
    /**
     * @var int
     */
    private $lineNumber;
    /**
     * @var ArticleId
     */
    private $articleId;
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
    private $sum;
    /**
     * @var Bonus
     */
    private $bonus;

    /**
     * @return int
     */
    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     *
     * @return DocumentItem
     */
    public function setLineNumber(int $lineNumber): DocumentItem
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

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
     * @return DocumentItem
     */
    public function setArticleId(ArticleId $articleId): DocumentItem
    {
        $this->articleId = $articleId;

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
     * @return DocumentItem
     */
    public function setQuantity(int $quantity): DocumentItem
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
     * @return DocumentItem
     */
    public function setPrice(Money $price): DocumentItem
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }

    /**
     * @param Money $sum
     *
     * @return DocumentItem
     */
    public function setSum(Money $sum): DocumentItem
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return Bonus
     */
    public function getBonus(): Bonus
    {
        return $this->bonus;
    }

    /**
     * @param Bonus $bonus
     *
     * @return DocumentItem
     */
    public function setBonus(Bonus $bonus): DocumentItem
    {
        $this->bonus = $bonus;

        return $this;
    }
}
