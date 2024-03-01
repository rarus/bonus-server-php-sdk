<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\Formatters;

use Rarus\BonusServer\Util\DateTimeParser;

final class NewHold
{
    public static function toArray(\Rarus\BonusServer\Holds\DTO\NewHold $newHold): array
    {
        return [
            'id' => $newHold->getHoldId()->getId(),
            'card_id' => $newHold->getCardId()->getId(),
            'sum' => $newHold->getSum(),
            'comment' => $newHold->getComment(),
            'date_to' => $newHold->getDateTo() ? DateTimeParser::convertToServerFormatTimestamp($newHold->getDateTo()): null,
            'duration' => $newHold->getDuration(),
        ];
    }
}
