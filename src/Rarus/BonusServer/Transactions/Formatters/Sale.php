<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Formatters;

use Rarus\BonusServer\Transactions;

/**
 * Class Sale
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class Sale
{
    /**
     * @param Sale $saleTrx
     *
     * @return array
     */
    public static function toArray(Transactions\DTO\Sale $saleTrx): array
    {
        $arChequeItems = [];

        foreach ($saleTrx->getChequeRows() as $chequeRow) {
            $arChequeItems[] = [
                'line_number' => $chequeRow->getLineNumber(),
                'article' => $chequeRow->getArticleId()->getId(),
                'name' => $chequeRow->getName(),
                'quantity' => $chequeRow->getQuantity(),
                'price' => (int)$chequeRow->getPrice()->getAmount(),
                'summ' => (int)$chequeRow->getSum()->getAmount(),
                'discount_summ' => (int)$chequeRow->getDiscount()->getAmount(),
            ];
        }

        $arTrx = [
            'operation_type' => 'sale',
            'card_id' => $saleTrx->getCardId()->getId(),
            'shop_id' => $saleTrx->getShopId()->getId(),
            'doc_id' => $saleTrx->getDocument()->getId(),
            'doc_type' => $saleTrx->getDocument()->getExternalId(),
            'kkm_id' => $saleTrx->getCashRegister()->getId(),
            'kkm_name' => $saleTrx->getCashRegister()->getName(),
            'cheque_number' => $saleTrx->getChequeNumber(),
            'author' => $saleTrx->getAuthorName(),
            'description' => $saleTrx->getDescription(),
            'bonus_payment' => $saleTrx->getBonusPayment(),
            'cheque_items' => $arChequeItems,
        ];

        return $arTrx;
    }
}