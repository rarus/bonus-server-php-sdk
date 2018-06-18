<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\ChequeRows;

use Money\Money;
use Rarus\BonusServer\Articles\DTO\ArticleId;

/**
 * Class ChequeRow
 *
 * @package Rarus\BonusServer\Transactions\DTO\ChequeRows
 */
final class ChequeRow
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
    private $sum;
    /**
     * @var Money
     */
    private $discount;

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
     * @return ChequeRow
     */
    public function setLineNumber(int $lineNumber): ChequeRow
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
     * @return ChequeRow
     */
    public function setArticleId(ArticleId $articleId): ChequeRow
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
     * @return ChequeRow
     */
    public function setName(string $name): ChequeRow
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
     * @return ChequeRow
     */
    public function setQuantity(int $quantity): ChequeRow
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
     * @return ChequeRow
     */
    public function setPrice(Money $price): ChequeRow
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
     * @return ChequeRow
     */
    public function setSum(Money $sum): ChequeRow
    {
        $this->sum = $sum;

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
     * @return ChequeRow
     */
    public function setDiscount(Money $discount): ChequeRow
    {
        $this->discount = $discount;

        return $this;
    }
}