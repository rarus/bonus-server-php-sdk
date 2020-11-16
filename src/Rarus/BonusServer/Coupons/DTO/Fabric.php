<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Coupons\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;

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
            ->setActive($arCoupon['active'])
            ->setUsed((int)$arCoupon['used'])
            ->setAddDate($arCoupon['add_date'] ? (new \DateTime())->setTimestamp($arCoupon['add_date']) : null)
            ->setActivateDate(
                $arCoupon['activate_date'] ? (new \DateTime())->setTimestamp($arCoupon['activate_date']) : null
            )
            ->setLastDate($arCoupon['last_date'] ? (new \DateTime())->setTimestamp($arCoupon['last_date']) : null);

        return $coupon;
    }
}
