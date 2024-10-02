<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Coupons\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Coupons\DTO\Coupon;
use Rarus\BonusServer\Coupons\DTO\CouponGroup;
use Rarus\BonusServer\Coupons\DTO\CouponGroupCollection;
use Rarus\BonusServer\Coupons\DTO\CouponGroupFilter;
use Rarus\BonusServer\Coupons\DTO\CouponGroupId;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Coupons\Transport\Role\Organization\DTO\PaginationResponse;
use Rarus\BonusServer\DiscountConditions\DTO\DiscountConditionCollection;
use Rarus\BonusServer\DiscountConditions\Formatters\DiscountCondition;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\DTO\Pagination;

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
     * @param bool $fullInfo
     * @param bool $check
     * @return Coupon
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getByCouponId(CouponId $couponId, bool $fullInfo = false, $check = false): Coupon
    {
        $this->log->debug(
            'rarus.bonus.server.coupons.transport.organization.getByCouponId.start',
            [
                'couponId' => $couponId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/coupon/%s?full_info=%s&check=%s', $couponId->getId(), (string)$fullInfo, (string)$check),
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

    public function getGroupById(CouponGroupId $couponGroupId): CouponGroup
    {
        $this->log->debug(
            'rarus.bonus.server.coupons.transport.organization.getGroupById.start',
            [
                'couponGroupId' => $couponGroupId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/coupon_group/%s', $couponGroupId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $couponGroup = \Rarus\BonusServer\Coupons\DTO\Fabric::initCouponGroupFromServerResponse($requestResult['coupon_group'], $this->apiClient->getTimezone());

        $this->log->debug(
            'rarus.bonus.server.coupons.transport.organization.getGroupById.start',
            [
                'couponId' => $couponGroup->getId()->getId(),
            ]
        );

        return $couponGroup;
    }

    /**
     * @throws ApiClientException
     * @throws UnknownException
     * @throws NetworkException
     */
    public function getGroupCollectionByFilter(CouponGroupFilter $couponGroupFilter, Pagination $pagination): PaginationResponse
    {
        $this->log->debug('rarus.bonus.server.coupons.transport.getGroupByFilter.start', [
            'pagination' => [
                'pageNumber' => $pagination->getPageNumber(),
                'pageSize' => $pagination->getPageSize(),
            ],
        ]);

        $url = sprintf(
            '/organization/coupon_group?%s%s&calculate_count=true',
            \Rarus\BonusServer\Coupons\Formatters\CouponGroup::toUrlArguments($couponGroupFilter),
            \Rarus\BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
        );

        $requestResult = $this->apiClient->executeApiRequest(
            $url,
            RequestMethodInterface::METHOD_GET
        );

        $couponGroupCollection = new CouponGroupCollection();
        foreach ($requestResult['coupon_groups'] as $couponGroup) {
            $couponGroupCollection->attach(
                \Rarus\BonusServer\Coupons\DTO\Fabric::initCouponGroupFromServerResponse(
                    $couponGroup,
                    $this->apiClient->getTimezone()
                )
            );
        }

        $paginationResponse = new PaginationResponse(
            $couponGroupCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.coupons.transport.getByFilter.finish',
            [
                'itemsCount' => $couponGroupCollection->count(),
            ]
        );

        return $paginationResponse;
    }
}
