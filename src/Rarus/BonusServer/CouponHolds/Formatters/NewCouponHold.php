<?php

declare(strict_types=1);

namespace Rarus\BonusServer\CouponHolds\Formatters;

use Rarus\BonusServer\Util\DateTimeParser;

final class NewCouponHold
{
    public static function toArray(\Rarus\BonusServer\CouponHolds\DTO\NewCouponHold $newCouponHold): array
    {
        return [
            'id' => $newCouponHold->getId()->getId(),
            'coupon_id' => $newCouponHold->getCouponId()->getId(),
            'card_id' => $newCouponHold->getCardId()->getId(),
            'comment' => $newCouponHold->getComment(),
            'date_to' => $newCouponHold->getDateTo() ? DateTimeParser::convertToServerFormatTimestamp($newCouponHold->getDateTo()) : null,
            'duration' => $newCouponHold->getDuration() ?: 0,
        ];
    }
}
