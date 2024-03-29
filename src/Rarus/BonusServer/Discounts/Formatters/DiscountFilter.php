<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Formatters;

final class DiscountFilter
{
    public static function toUrlArguments(\Rarus\BonusServer\Discounts\DTO\DiscountFilter $discountFilter): string
    {
        $arFilter = [];

        if (!empty($discountFilter->getGroupId())) {
            $arFilter['discount_group_id'] = $discountFilter->getGroupId();
        }

        if (!empty($discountFilter->getDateFrom())) {
            $arFilter['date_from'] = $discountFilter->getDateFrom()->getTimestamp();
        }

        if (!empty($discountFilter->getDateTo())) {
            $arFilter['date_to'] = $discountFilter->getDateTo()->getTimestamp();
        }

        if (!empty($discountFilter->getShopId())) {
            $arFilter['shop_id'] = $discountFilter->getShopId();
        }

        if (!empty($discountFilter->getFunction())) {
            $arFilter['function'] = $discountFilter->getFunction();
        }

        $arFilter['showdeleted'] = $discountFilter->getShowDeleted() ? 'true' : 'false';
        $arFilter['shop_all'] = $discountFilter->getShopAll() ? 'true' : 'false';
        $arFilter['full_info'] = $discountFilter->getFullInfo() ? 'true' : 'false';
        $arFilter['upload_to_bitrix24'] = $discountFilter->getUploadToBitrix() ? 'true' : 'false';
        $arFilter['ismanual'] = $discountFilter->getIsManual() ? 'true' : 'false';

        return http_build_query($arFilter);
    }
}
