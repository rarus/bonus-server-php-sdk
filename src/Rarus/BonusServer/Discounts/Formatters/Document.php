<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Formatters;

use Rarus\BonusServer\Discounts;
use Rarus\BonusServer\Transactions\Formatters\ChequeRow;

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

        $arResult = [
            'shop_id' => $discountDocument->getShopId()->getId(),
            'cheque_items' => $arChequeItems,
        ];

        if ($discountDocument->getCard() !== null) {
            $arResult['card_id'] = $discountDocument->getCard()->getCardId()->getId();
            $arResult['card_code'] = $discountDocument->getCard()->getCode();
            $arResult['card_barcode'] = $discountDocument->getCard()->getBarcode();
        }

        return $arResult;
    }
}