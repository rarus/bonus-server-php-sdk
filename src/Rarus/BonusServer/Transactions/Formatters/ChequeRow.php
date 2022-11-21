<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Formatters;

use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Util\MoneyParser;

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
            'price' => (float)MoneyParser::convertMoneyToString($chequeRow->getPrice()),
            'summ' => (float)MoneyParser::convertMoneyToString($chequeRow->getSum()),
            'discount_summ' => (float)MoneyParser::convertMoneyToString($chequeRow->getDiscount()),
        ];
    }
}
