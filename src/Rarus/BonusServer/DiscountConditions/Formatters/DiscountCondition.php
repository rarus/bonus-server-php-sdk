<?php

declare(strict_types=1);

namespace Rarus\BonusServer\DiscountConditions\Formatters;

use Rarus\BonusServer\DiscountConditions\DTO\DiscountConditionFilter;

final class DiscountCondition
{
    public static function toUrlArguments(DiscountConditionFilter $discountConditionFilter): string
    {
        $arFilter = [];

        if (!empty($discountConditionFilter->getDiscountId())) {
            $arFilter['discount_id'] = $discountConditionFilter->getDiscountId()->getId();
        }

        if (!empty($discountConditionFilter->getType())) {
            $arFilter['type'] = $discountConditionFilter->getType();
        }

        if (!empty($discountConditionFilter->getFunction())) {
            $arFilter['function'] = $discountConditionFilter->getFunction();
        }

        return http_build_query($arFilter);
    }
}
