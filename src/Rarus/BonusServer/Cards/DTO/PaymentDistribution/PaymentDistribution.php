<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Cards\DTO\PaymentDistribution;

use Money\Money;
use Rarus\BonusServer\Articles\DTO\ArticleId;

/**
 * Class PaymentDistribution
 *
 * @package Rarus\BonusServer\Cards\DTO\PaymentDistribution
 */
class PaymentDistribution
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
     * @var Money
     */
    private $sum;
    /**
     * @var float
     */
    private $maxPaymentPercent;
    /**
     * @var float
     */
    private $maxPaymentSum;
    /**
     * @var Money
     */
    private $paymentSum;

    /**
     * PaymentDistribution constructor.
     *
     * @param int       $lineNumber
     * @param ArticleId $articleId
     * @param Money     $sum
     * @param float     $maxPaymentPercent
     * @param float     $maxPaymentSum
     * @param Money     $paymentSum
     */
    public function __construct(
        int $lineNumber,
        ArticleId $articleId,
        Money $sum,
        float $maxPaymentPercent,
        float $maxPaymentSum,
        Money $paymentSum
    ) {
        $this->lineNumber = $lineNumber;
        $this->articleId = $articleId;
        $this->sum = $sum;
        $this->maxPaymentPercent = $maxPaymentPercent;
        $this->maxPaymentSum = $maxPaymentSum;
        $this->paymentSum = $paymentSum;
    }

    /**
     * @return int
     */
    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    /**
     * @return ArticleId
     */
    public function getArticleId(): ArticleId
    {
        return $this->articleId;
    }

    /**
     * @return Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }

    /**
     * @return float
     */
    public function getMaxPaymentPercent(): float
    {
        return $this->maxPaymentPercent;
    }

    /**
     * @return float
     */
    public function getMaxPaymentSum(): float
    {
        return $this->maxPaymentSum;
    }

    /**
     * @return Money
     */
    public function getPaymentSum(): Money
    {
        return $this->paymentSum;
    }
}
