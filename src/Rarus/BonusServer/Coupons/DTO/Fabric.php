<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Coupons\DTO;

use InvalidArgumentException;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\DiscountConditions\DTO\DiscountCondition;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Util\DateTimeParser;
use Rarus\BonusServer\Util\Utils;
use TypeError;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Coupons\DTO
 */
class Fabric
{
    /**
     * @param array $arCoupon
     *
     * @return Coupon
     * @throws \Exception
     */
    public static function initCouponFromServerResponse(array $arCoupon): Coupon
    {
        $coupon = new Coupon(new CouponId($arCoupon['id']));
        $coupon->setCardId(new CardId($arCoupon['card_id']))
            ->setCouponGroupId(new CouponGroupId($arCoupon['coupon_group_id']))
            ->setActive($arCoupon['active'])
            ->setUsed((int)$arCoupon['used'])
            ->setAddDate($arCoupon['add_date'] ? (new \DateTime())->setTimestamp($arCoupon['add_date']) : null)
            ->setActivateDate(
                $arCoupon['activate_date'] ? (new \DateTime())->setTimestamp($arCoupon['activate_date']) : null
            )
            ->setLastDate($arCoupon['last_date'] ? (new \DateTime())->setTimestamp($arCoupon['last_date']) : null);

        return $coupon;
    }

    /**
     * @throws ApiClientException
     */
    public static function initCouponGroupFromServerResponse(array $arCoupon, \DateTimeZone $dateTimeZone): CouponGroup
    {
        $couponGroup = new CouponGroup();

        $couponGroup
            ->setId(new CouponGroupId($arCoupon['id']))
            ->setName($arCoupon['name'])
            ->setDescription($arCoupon['description'])
            ->setType($arCoupon['type'])
            ->setOncard($arCoupon['oncard'])
            ->setDeleted($arCoupon['deleted'])
            ->setPeriodType($arCoupon['period_type'])
            ->setUseDays($arCoupon['use_days'])
            ->setOffsetActivationDays($arCoupon['offset_activation_days'])
        ;

        if (!empty($arCoupon['start_date'])) {
            $couponGroup->setStartDate(DateTimeParser::parseTimestampFromServerResponse((string)$arCoupon['start_date'], $dateTimeZone));
        }

        if (!empty($arCoupon['end_date'])) {
            $couponGroup->setEndDate(DateTimeParser::parseTimestampFromServerResponse((string)$arCoupon['end_date'], $dateTimeZone));
        }

        if (!empty($arCoupon['parent_id'])) {
            $couponGroup->setParentId(new CouponGroupId($arCoupon['parent_id']));
        }

        return $couponGroup;
    }
}
