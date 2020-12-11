<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Coupons\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Coupons\DTO\Coupon;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Transport\AbstractTransport;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Coupons\Transport\Role\Organization
 *
 */
class Transport extends AbstractTransport
{
    /**
     * @param CouponId $couponId
     * @param bool     $fullInfo
     *
     * @return Coupon
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Exception
     */
    public function getByCouponId(CouponId $couponId, bool $fullInfo = false): Coupon
    {
        $this->log->debug(
            'rarus.bonus.server.coupons.transport.organization.getByCouponId.start',
            [
                'couponId' => $couponId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/coupon/%s?full_info=%s', $couponId->getId(), (string)$fullInfo),
            RequestMethodInterface::METHOD_GET
        );

        $coupon = \Rarus\BonusServer\Coupons\DTO\Fabric::initCouponFromServerResponse($requestResult['coupon']);

        $this->log->debug(
            'rarus.bonus.server.coupons.transport.organization.getByCouponId.start',
            [
                'couponId' => $coupon->getId()->getId(),
            ]
        );

        return $coupon;
    }
}
