<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Formatters;

use Rarus\BonusServer;

/**
 * Class CardFilter
 *
 * @package Rarus\BonusServer\Cards\Formatters
 */
class CardFilter
{
    /**
     * @param BonusServer\Cards\DTO\CardFilter $cardFilter
     *
     * @return string
     */
    public static function toUrlArguments(BonusServer\Cards\DTO\CardFilter $cardFilter): string
    {
        $arFilter = [];
        if ($cardFilter->getCode() !== '') {
            $arFilter['code'] = $cardFilter->getCode();
        }
        if ($cardFilter->getBarcode() !== null) {
            $arFilter['barcode'] = $cardFilter->getBarcode()->getCode();
        }
        if ($cardFilter->getCardLevelId() !== '') {
            $arFilter['card_level_id'] = $cardFilter->getCardLevelId();
        }
        if ($cardFilter->getEmail() !== '') {
            $arFilter['email'] = $cardFilter->getEmail();
        }
        if ($cardFilter->getPhone() !== '') {
            $arFilter['phone'] = $cardFilter->getPhone();
        }

        return http_build_query($arFilter);
    }
}
