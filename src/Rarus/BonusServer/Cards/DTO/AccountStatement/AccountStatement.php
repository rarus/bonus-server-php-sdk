<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\AccountStatement;

use Money\Money;
use Rarus\BonusServer\Cards\DTO\Balance\Balance;
use Rarus\BonusServer\Cards\DTO\TransactionAmount\TransactionAmountCollection;
use Rarus\BonusServer\Transactions\DTO\Points\PointCollection;

/**
 * Class AccountStatement
 *
 * @package Rarus\BonusServer\Cards\DTO\AccountStatement
 */
final class AccountStatement
{
    /**
     * @var Balance
     */
    private $balance;
    /**
     * @var TransactionAmountCollection
     */
    private $transactions;
    /**
     * @var PointCollection
     */
    private $points;

    /**
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this->points;
    }

    /**
     * @param PointCollection $points
     *
     * @return AccountStatement
     */
    public function setPoints(PointCollection $points): AccountStatement
    {
        $this->points = $points;

        return $this;
    }

    /**
     * @return Balance
     */
    public function getBalance(): Balance
    {
        return $this->balance;
    }

    /**
     * @param Balance $balance
     *
     * @return AccountStatement
     */
    public function setBalance(Balance $balance): AccountStatement
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return TransactionAmountCollection
     */
    public function getTransactions(): TransactionAmountCollection
    {
        return $this->transactions;
    }

    /**
     * @param TransactionAmountCollection $transactions
     *
     * @return AccountStatement
     */
    public function setTransactions(TransactionAmountCollection $transactions): AccountStatement
    {
        $this->transactions = $transactions;

        return $this;
    }
}