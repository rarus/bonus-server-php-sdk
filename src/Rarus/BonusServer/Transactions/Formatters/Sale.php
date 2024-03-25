<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Formatters;

use Rarus\BonusServer\Discounts\Formatters\DiscountRow;
use Rarus\BonusServer\Transactions;

/**
 * Class Sale
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class Sale
{
    /**
     * @param Transactions\DTO\Sale $saleTrx
     *
     * @return array
     */
    public static function toArray(Transactions\DTO\Sale $saleTrx): array
    {
        $arChequeItems = [];

        foreach ($saleTrx->getChequeRows() as $chequeRow) {
            $arChequeItems[] = ChequeRow::toArray($chequeRow);
        }

        $arChequeBonus = [];

        if ($saleTrx->getDiscountItemCollection()) {
            foreach ($saleTrx->getDiscountItemCollection() as $discountItem) {
                $arChequeBonus[] = DiscountRow::toArray($discountItem);
            }
        }

        $arPaymentTypes = [];
        if ($saleTrx->getPaymentTypeCollection()) {
            foreach ($saleTrx->getPaymentTypeCollection() as $paymentType) {
                $arPaymentTypes[] = PaymentType::toArray($paymentType);
            }
        }

        $arCertPayments = [];
        if ($saleTrx->getCertPaymentCollection()) {
            foreach ($saleTrx->getCertPaymentCollection() as $certPayment) {
                $arCertPayments[] = CertPayment::toArray($certPayment);
            }
        }

        $arCalculateHistory = [];
        if ($saleTrx->getCalculateHistoryCollection()) {
            foreach ($saleTrx->getCalculateHistoryCollection() as $discount) {
                $arCalculateHistory[] = DiscountRow::toCalculateHistory($discount);
            }
        }

        return [
            'operation_type' => 'sale',
            'level_up'       => true,
            'card_id'        => $saleTrx->getCardId()->getId(),
            'shop_id'        => $saleTrx->getShopId()->getId(),
            'doc_id'         => $saleTrx->getDocument()->getId(),
            'doc_type'       => $saleTrx->getDocument()->getExternalId(),
            'kkm_id'         => $saleTrx->getCashRegister()->getId(),
            'kkm_name'       => $saleTrx->getCashRegister()->getName(),
            'cheque_number'  => $saleTrx->getChequeNumber(),
            'author'         => $saleTrx->getAuthorName(),
            'description'    => $saleTrx->getDescription(),
            'bonus_payment'  => $saleTrx->getBonusPayment(),
            'cheque_items'   => $arChequeItems,
            'cheque_bonus'   => $arChequeBonus,
            'coupon'         => $saleTrx->getCouponId() ? $saleTrx->getCouponId()->getId() : '',
            'payment_types'  => $arPaymentTypes,
            'cert_payments'  => $arCertPayments,
            'hold_id'        => $saleTrx->getHoldId() ? $saleTrx->getHoldId()->getId() : null,
            'hold_used'      => $saleTrx->isHoldUsed(),
            'test'           => $saleTrx->isTest(),
            'calculate_history' => $arCalculateHistory
        ];
    }
}
