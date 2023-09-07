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

        if (!empty($discountFilter->getShowDeleted())) {
            $arFilter['showdeleted'] = $discountFilter->getShowDeleted();
        }

        if (!empty($discountFilter->getShopAll())) {
            $arFilter['shop_all'] = $discountFilter->getShopAll();
        }

        if (!empty($discountFilter->getShopAll())) {
            $arFilter['full_info'] = $discountFilter->getShopAll();
        }

        if (!empty($discountFilter->getFunction())) {
            $arFilter['function'] = $discountFilter->getFunction();
        }

        if (!empty($discountFilter->getUploadToBitrix())) {
            $arFilter['upload_to_bitrix24'] = $discountFilter->getUploadToBitrix() ? 'true' : 'false';
        }

        if (!empty($discountFilter->getIsManual())) {
            $arFilter['ismanual'] = $discountFilter->getIsManual();
        }

        return http_build_query($arFilter);
    }
}
