<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Formatters;

use Rarus\BonusServer\Transactions;

/**
 * Class Refund
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class Refund
{
    /**
     * @param Transactions\DTO\Refund $refundTrx
     *
     * @return array
     */
    public static function toArray(Transactions\DTO\Refund $refundTrx): array
    {
        $arChequeItems = [];

        foreach ($refundTrx->getChequeRows() as $chequeRow) {
            $arChequeItems[] = ChequeRow::toArray($chequeRow);
        }

        return [
            'operation_type'     => 'refund',
            'auto_bonus_refund'  => true,
            'auto_bonus_payment' => true,
            'card_id'            => $refundTrx->getCardId()->getId(),
            'shop_id'            => $refundTrx->getShopId()->getId(),
            'doc_id'             => $refundTrx->getDocument()->getId(),
            'doc_type'           => $refundTrx->getDocument()->getExternalId(),
            'kkm_id'             => $refundTrx->getCashRegister()->getId(),
            'kkm_name'           => $refundTrx->getCashRegister()->getName(),
            'cheque_number'      => $refundTrx->getChequeNumber(),
            'author'             => $refundTrx->getAuthorName(),
            'description'        => $refundTrx->getDescription(),
            'doc_id_refund'      => $refundTrx->getRefundDocument()->getId(),
            'refund_bonus'       => $refundTrx->getRefundBonus(),
            'cheque_items'       => $arChequeItems,
            'coupon'             => $refundTrx->getCouponId() ? $refundTrx->getCouponId()->getId() : ''
        ];
    }
}
