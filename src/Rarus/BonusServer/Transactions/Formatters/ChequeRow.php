<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Formatters;

use Rarus\BonusServer\Transactions;

/**
 * Class ChequeRow
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class ChequeRow
{
    /**
     * @param Transactions\DTO\ChequeRows\ChequeRow $chequeRow
     *
     * @return array
     */
    public static function toArray(Transactions\DTO\ChequeRows\ChequeRow $chequeRow): array
    {
        return [
            'line_number' => $chequeRow->getLineNumber(),
            'article' => $chequeRow->getArticleId()->getId(),
            'name' => $chequeRow->getName(),
            'quantity' => $chequeRow->getQuantity(),
            'price' => (int)$chequeRow->getPrice()->getAmount(),
            'summ' => (int)$chequeRow->getSum()->getAmount(),
            'discount_summ' => (int)$chequeRow->getDiscount()->getAmount(),
        ];
    }
}
