<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Coupons\Formatters;

use Rarus\BonusServer\Coupons\DTO\CouponGroupFilter;
use Rarus\BonusServer\Util\DateTimeParser;

final class CouponGroup
{
    public static function toUrlArguments(CouponGroupFilter $filter): string
    {
        $arFilter = [];

        if (!empty($filter->getType())) {
            $arFilter['type'] = $filter->getType();
        }

        if (!empty($filter->getStartDateFrom())) {
            $arFilter['start_date_from'] = DateTimeParser::convertToServerFormatTimestamp($filter->getStartDateFrom());
        }

        if (!empty($filter->getEndDateFrom())) {
            $arFilter['start_date_to'] = DateTimeParser::convertToServerFormatTimestamp($filter->getEndDateFrom());
        }

        if (!empty($filter->getEndDateFrom())) {
            $arFilter['end_date_from'] = DateTimeParser::convertToServerFormatTimestamp($filter->getEndDateFrom());
        }

        if (!empty($filter->getEndDateTo())) {
            $arFilter['end_date_to'] = DateTimeParser::convertToServerFormatTimestamp($filter->getEndDateTo());
        }

        if (!empty($filter->getParentId())) {
            $arFilter['parent_id'] = $filter->getParentId()->getId();
        }

        if (!empty($filter->getNameFilter())) {
            $arFilter['name_filter'] = $filter->getNameFilter();
        }

        if ($filter->isShowDeleted()) {
            $arFilter['showdeleted'] = true;
        }

        return http_build_query($arFilter);
    }
}
