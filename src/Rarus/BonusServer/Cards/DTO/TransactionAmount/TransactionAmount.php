<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\TransactionAmount;

use Money\Money;

/**
 * Class TransactionAmount
 *
 * @package Rarus\BonusServer\Cards\DTO\TransactionAmount
 */
final class TransactionAmount
{
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var Money
     */
    private $transactionSum;

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return TransactionAmount
     */
    public function setDate(\DateTime $date): TransactionAmount
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Money
     */
    public function getTransactionSum(): Money
    {
        return $this->transactionSum;
    }

    /**
     * @param Money $transactionSum
     *
     * @return TransactionAmount
     */
    public function setTransactionSum(Money $transactionSum): TransactionAmount
    {
        $this->transactionSum = $transactionSum;

        return $this;
    }
}
