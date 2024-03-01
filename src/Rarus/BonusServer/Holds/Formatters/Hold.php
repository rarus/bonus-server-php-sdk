<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\Formatters;

use Rarus\BonusServer\Holds\DTO\HoldFilter;

final class Hold
{
    public static function toUrlArguments(HoldFilter $holdFilter): string
    {
        $arFilter = [];

        if (!empty($holdFilter->getCardId())) {
            $arFilter['card_id'] = $holdFilter->getCardId()->getId();
        }

        if (!empty($holdFilter->getStartDateFrom())) {
            $arFilter['start_date_from'] = $holdFilter->getStartDateFrom()->getTimestamp();
        }

        if (!empty($holdFilter->getStartDateTo())) {
            $arFilter['start_date_to'] = $holdFilter->getStartDateTo()->getTimestamp();
        }

        if (!empty($holdFilter->getEndDateFrom())) {
            $arFilter['end_date_from'] = $holdFilter->getEndDateFrom()->getTimestamp();
        }

        if (!empty($holdFilter->getEndDateTo())) {
            $arFilter['end_date_from'] = $holdFilter->getEndDateTo()->getTimestamp();
        }

        return http_build_query($arFilter);
    }

    public static function toArray(\Rarus\BonusServer\Holds\DTO\Hold $hold): array
    {
        return [
            'id' => $hold->getHoldId()->getId(),
            'card_id' => $hold->getCardId()->getId(),
            'card_name' => $hold->getCardName(),
            'sum' => $hold->getSum(),
            'comment' => $hold->getComment(),
            'add_date' => $hold->getAddDate()->format(DATE_ATOM),
            'date_to' => $hold->getDateTo()->format(DATE_ATOM),
        ];
    }
}
