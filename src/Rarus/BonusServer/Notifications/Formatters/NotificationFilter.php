<?php

namespace Rarus\BonusServer\Notifications\Formatters;

use Rarus\BonusServer\Notifications\DTO\NotificationOrganizationFilter;
use Rarus\BonusServer\Notifications\DTO\NotificationUserFilter;

class NotificationFilter
{
    public static function toUrlArguments(NotificationUserFilter $filter): string
    {
        $arFilter = [];

        if ($filter->isExpired()) {
            $arFilter['expired'] = true;
        }

        if ($filter->getFrom()) {
            $arFilter['from'] = $filter->getFrom()->getTimestamp();
        }

        return http_build_query($arFilter);
    }

    public static function toUrlArgumentsFromOrganization(NotificationOrganizationFilter $filter): string
    {
        $arFilter = [];

        if ($filter->getNotificationId()) {
            $arFilter['id'] = $filter->getNotificationId()->getId();
        }

        if ($filter->getUserId()) {
            $arFilter['user_id'] = $filter->getUserId()->getId();
        }

        if ($filter->getCardId()) {
            $arFilter['card_id'] = $filter->getCardId()->getId();
        }

        if ($filter->getFrom()) {
            $arFilter['from'] = $filter->getFrom()->getTimestamp();
        }

        if ($filter->getExpired()) {
            $arFilter['expired'] = $filter->getExpired()->getTimestamp();
        }

        return http_build_query($arFilter);
    }
}