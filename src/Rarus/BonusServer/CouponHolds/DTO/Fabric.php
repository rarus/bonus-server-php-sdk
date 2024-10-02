<?php

declare(strict_types=1);


namespace Rarus\BonusServer\CouponHolds\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Util\DateTimeParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Coupons\DTO
 */
class Fabric
{
    /**
     * @throws ApiClientException
     */
    public static function initCouponHoldFromServerResponse(array $data, \DateTimeZone $dateTimeZone): CouponHold
    {
        $dto = new CouponHold(new CouponHoldId($data['id']));

        if (!empty($data['coupon_id'])) {
            $dto->setCouponId(new CouponId($data['coupon_id']));
        }

        if (!empty($data['card_id'])) {
            $dto->setCardId(new CardId($data['card_id']));
        }

        if (!empty($data['comment'])) {
            $dto->setComment($data['comment']);
        }

        if (!empty($data['add_date'])) {
            $dto->setAddDate(DateTimeParser::parseTimestampFromServerResponse((string)$data['add_date'], $dateTimeZone));
        }

        if (!empty($data['date_to'])) {
            $dto->setDateTo(DateTimeParser::parseTimestampFromServerResponse((string)$data['date_to'], $dateTimeZone));
        }

        return $dto;
    }
}
