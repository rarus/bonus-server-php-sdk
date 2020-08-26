<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points\Transactions;

use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Transactions\DTO\Points\Transactions
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var TransactionCollection
     */
    private $transactionCollection;

    /**
     * PaginationResponse constructor.
     *
     * @param TransactionCollection $transactionCollection
     * @param Pagination            $pagination
     */
    public function __construct(TransactionCollection $transactionCollection, Pagination $pagination)
    {
        $this->transactionCollection = $transactionCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return TransactionCollection
     */
    public function getTransactionCollection(): TransactionCollection
    {
        return $this->transactionCollection;
    }
}
