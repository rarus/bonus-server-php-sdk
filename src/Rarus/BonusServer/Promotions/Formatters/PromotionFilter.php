<?php

namespace Rarus\BonusServer\Promotions\Formatters;

class PromotionFilter
{
    public static function toUrlArguments(\Rarus\BonusServer\Promotions\DTO\PromotionFilter $filter): string
    {
        $arFilter = [];

        if ($filter->getFrom()) {
            $arFilter['from'] = $filter->getFrom()->getTimestamp();
        }

        if ($filter->getTo()) {
            $arFilter['from'] = $filter->getTo()->getTimestamp();
        }

        if ($filter->getShopId()) {
            $arFilter['shop_id'] = $filter->getShopId()->getId();
        }

        $arFilter['with_full_description'] = $filter->isWithFullDescription();

        return http_build_query($arFilter);
    }
}