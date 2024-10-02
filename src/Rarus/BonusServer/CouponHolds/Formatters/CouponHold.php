<?php

declare(strict_types=1);

namespace Rarus\BonusServer\CouponHolds\Formatters;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Coupons\DTO\CouponId;

final class CouponHold
{
    public static function toUrlArguments(?CardId $cardId, ?CouponId $couponId): string
    {
        $arFilter = [];

        if (!empty($cardId)) {
            $arFilter['card_id'] = $cardId->getId();
        }

        if (!empty($couponId)) {
            $arFilter['coupon_id'] = $couponId->getId();
        }

        return http_build_query($arFilter);
    }
}
