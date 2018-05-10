<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO;

use Money\Money;

class Fabric
{
    /**
     * @param array $arCard
     *
     * @return Card
     */
    public static function initCardFromServerResponse(array $arCard): Card
    {
        $card = (new Card())
            ->setCardId(new CardId($arCard['id']))
            ->setParentId(new CardId($arCard['parent_id']))
            ->setName((string)$arCard['name'])
            ->setBarcode((string)$arCard['barcode'])
            ->setCode((string)$arCard['barcode'])
            ->setDescription((string)$arCard['description'])
            ->setCardStatus(\Rarus\BonusServer\Cards\DTO\Status\Fabric::initFromServerResponse($arCard));

        if ($arCard['date_last_transaction'] !== 0) {
            $card->setDateLastTransaction(\DateTime::createFromFormat('U', (string)$arCard['date_last_transaction']));
        }
        if ($arCard['last_transaction'] !== '') {
            $card->setLastTransaction((string)$arCard['last_transaction']);
        }

        return $card;
    }
}