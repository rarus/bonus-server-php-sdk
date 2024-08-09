<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\Formatters;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

final class HoldItem
{
    public static function toArray(\Rarus\BonusServer\Holds\DTO\HoldItem $holdItem): array
    {
        $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'hold_id' => $holdItem->getHoldId()->getId(),
            'hold_used' => $holdItem->getHoldUsed() ?? null,
            'hold_sum' => (float)$decimalFormatter->format($holdItem->getHoldSum()),
        ];
    }
}
