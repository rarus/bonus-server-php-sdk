<?php

declare(strict_types=1);


namespace Rarus\BonusServer\CouponHolds\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\CouponHolds\DTO\CouponHold;
use Rarus\BonusServer\CouponHolds\DTO\CouponHoldCollection;
use Rarus\BonusServer\CouponHolds\DTO\CouponHoldId;
use Rarus\BonusServer\CouponHolds\DTO\NewCouponHold;
use Rarus\BonusServer\CouponHolds\Transport\Role\Organization\DTO\PaginationResponse;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\CouponHolds\Transport\Role\Organization
 *
 */
class Transport extends AbstractTransport
{
    /**
     * @param CouponHoldId $couponHoldId
     * @return CouponHold
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function getById(CouponHoldId $couponHoldId): CouponHold
    {
        $this->log->debug(
            'rarus.bonus.server.coupon_holds.transport.organization.getById.start',
            [
                'couponHoldId' => $couponHoldId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/coupon_hold/%s', $couponHoldId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $couponHold = \Rarus\BonusServer\CouponHolds\DTO\Fabric::initCouponHoldFromServerResponse($requestResult['coupon_hold'], $this->apiClient->getTimezone());

        $this->log->debug(
            'rarus.bonus.server.coupon_holds.transport.organization.getById.start',
            [
                'couponHoldId' => $couponHold->getId()->getId(),
            ]
        );

        return $couponHold;
    }

    /**
     * @throws ApiClientException
     * @throws UnknownException
     * @throws NetworkException
     */
    public function getList(?CouponId $couponId, ?CardId $cardId, Pagination $pagination): PaginationResponse
    {
        $this->log->debug('rarus.bonus.server.couponHolds.transport.getList.start', [
            'pagination' => [
                'pageNumber' => $pagination->getPageNumber(),
                'pageSize' => $pagination->getPageSize(),
            ],
        ]);

        $url = sprintf(
            '/organization/coupon_hold?%s%s&calculate_count=true',
            \Rarus\BonusServer\CouponHolds\Formatters\CouponHold::toUrlArguments($cardId, $couponId),
            \Rarus\BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
        );

        $requestResult = $this->apiClient->executeApiRequest(
            $url,
            RequestMethodInterface::METHOD_GET
        );

        $couponHoldCollection = new CouponHoldCollection();
        foreach ($requestResult['coupon_holds'] as $couponHold) {
            $couponHoldCollection->attach(
                \Rarus\BonusServer\CouponHolds\DTO\Fabric::initCouponHoldFromServerResponse(
                    $couponHold,
                    $this->apiClient->getTimezone()
                )
            );
        }

        $paginationResponse = new \Rarus\BonusServer\CouponHolds\Transport\Role\Organization\DTO\PaginationResponse(
            $couponHoldCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.couponHolds.transport.getList.finish',
            [
                'itemsCount' => $couponHoldCollection->count(),
            ]
        );

        return $paginationResponse;
    }

    /**
     * @param NewCouponHold $newCouponHold
     * @return CouponHoldId
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function add(NewCouponHold $newCouponHold): CouponHoldId
    {
        $this->log->debug(
            'rarus.bonus.server.coupon_holds.transport.organization.new.start',
            [
                'couponHoldId' => $newCouponHold->getId(),
            ]
        );

        $requestData = \Rarus\BonusServer\CouponHolds\Formatters\NewCouponHold::toArray($newCouponHold);

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/coupon_hold/add',
            RequestMethodInterface::METHOD_POST,
            $requestData
        );

        $holdId = new CouponHoldId($requestResult['id']);

        $this->log->debug('rarus.bonus.server.hold.transport.add.finish', [
            'id' => $holdId->getId()
        ]);

        return $holdId;
    }

    /**
     * @param CouponHoldId $couponHoldId
     * @return void
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function delete(CouponHoldId $couponHoldId): void
    {
        $this->log->debug(
            'rarus.bonus.server.coupon_holds.transport.organization.delete.start',
            [
                'couponHoldId' => $couponHoldId->getId(),
            ]
        );

        $this->apiClient->executeApiRequest(
            sprintf('/organization/coupon_hold/%s/delete', $couponHoldId->getId()),
            RequestMethodInterface::METHOD_GET
        );
    }
}
