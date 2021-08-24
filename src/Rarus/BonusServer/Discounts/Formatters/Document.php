<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Formatters;

use Rarus\BonusServer\Discounts;
use Rarus\BonusServer\Transactions\Formatters\CertPayment;
use Rarus\BonusServer\Transactions\Formatters\ChequeRow;
use Rarus\BonusServer\Transactions\Formatters\PaymentType;

/**
 * Class Document
 *
 * @package Rarus\BonusServer\Discounts\Formatters
 */
class Document
{
    /**
     * @param Discounts\DTO\Document $discountDocument
     *
     * @return array
     */
    public static function toArray(Discounts\DTO\Document $discountDocument): array
    {
        $arChequeItems = [];

        foreach ($discountDocument->getChequeRows() as $chequeRow) {
            $arChequeItems[] = ChequeRow::toArray($chequeRow);
        }

        $arPaymentTypes = [];
        if ($discountDocument->getPaymentTypeCollection()) {
            foreach ($discountDocument->getPaymentTypeCollection() as $paymentType) {
                $arPaymentTypes[] = PaymentType::toArray($paymentType);
            }
        }

        $arCertPayments = [];
        if ($discountDocument->getCertPaymentCollection()) {
            foreach ($discountDocument->getCertPaymentCollection() as $certPayment) {
                $arCertPayments[] = CertPayment::toArray($certPayment);
            }
        }

        $arResult = [
            'shop_id' => $discountDocument->getShopId()->getId(),
            'cheque_items' => $arChequeItems,
            'payment_types' => $arPaymentTypes,
            'cert_payments' => $arCertPayments,
        ];

        if ($discountDocument->getCard() !== null) {
            $arResult['card_id'] = $discountDocument->getCard()->getCardId()->getId();
            $arResult['card_code'] = $discountDocument->getCard()->getCode();
            $arResult['card_barcode'] = $discountDocument->getCard()->getBarcode()->getCode();
        }

        if ($discountDocument->getCouponId()) {
            $arResult['coupon'] = $discountDocument->getCouponId()->getId();
        }

        return $arResult;
    }
}
