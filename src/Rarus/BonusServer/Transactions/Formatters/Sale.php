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
            'coupon'         => $saleTrx->getCouponId() ? $saleTrx->getCouponId()->getId() : ''
        ];
    }
}
