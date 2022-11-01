<?php

namespace Rarus\BonusServer\Promotions\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Notifications\Transport\DTO\PaginationResponse;
use Rarus\BonusServer\Promotions\DTO\Fabric;
use Rarus\BonusServer\Promotions\DTO\Promotion;
use Rarus\BonusServer\Promotions\DTO\PromotionCollection;
use Rarus\BonusServer\Promotions\DTO\PromotionId;
use Rarus\BonusServer\Promotions\Formatters\PromotionFilter;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\DTO\Pagination;

class Transport extends AbstractTransport
{
    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function store(Promotion $promotion): Promotion
    {
        $this->log->debug(
            'rarus.bonus.server.promotions.transport.organization.store.start',
            ['promotion' => \Rarus\BonusServer\Promotions\Formatters\Promotion::toArray($promotion)]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/promotion/add',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Promotions\Formatters\Promotion::toArray($promotion)
        );

        $addedPromotion = $this->getById(new PromotionId($requestResult['id']));

        $this->log->debug(
            'rarus.bonus.server.promotions.transport.organization.store.finish',
            ['added_promotion' => \Rarus\BonusServer\Promotions\Formatters\Promotion::toArray($addedPromotion)]
        );

        return $addedPromotion;
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function getById(PromotionId $promotionId): Promotion
    {
        $this->log->debug(
            'rarus.bonus.server.promotions.transport.organization.getById.start',
            ['id' => $promotionId->getId()]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/promotion/%s', $promotionId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $promotion = Fabric::initPromotionFromServerResponse($requestResult['promotion']);

        $this->log->debug(
            'rarus.bonus.server.promotions.transport.organization.getById.finish',
            [
                'response' => $requestResult
            ]
        );

        return $promotion;
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function list(
        \Rarus\BonusServer\Promotions\DTO\PromotionFilter $filter,
        Pagination $pagination
    ): \Rarus\BonusServer\Promotions\Transport\DTO\PaginationResponse {
        $this->log->debug(
            'rarus.bonus.server.promotions.transport.organization.list.start',
            ['filters' => PromotionFilter::toUrlArguments($filter)]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                '/organization/promotion?%s%s',
                PromotionFilter::toUrlArguments($filter),
                \Rarus\BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
            ),
            RequestMethodInterface::METHOD_GET
        );

        $promotionCollection = new PromotionCollection();
        foreach ($requestResult['promotions'] as $arPromotion) {
            $promotionCollection->attach(
                Fabric::initPromotionFromServerResponse($arPromotion)
            );
        }

        $paginationResponse = new \Rarus\BonusServer\Promotions\Transport\DTO\PaginationResponse(
            $promotionCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.promotions.transport.organization.list.finish',
            ['count' => $promotionCollection->count()]
        );

        return $paginationResponse;
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function delete(PromotionId $promotionId): void
    {
        $this->log->debug(
            'rarus.bonus.server.promotions.transport.organization.delete.start',
            ['id' => $promotionId->getId()]
        );

        $this->apiClient->executeApiRequest(
            sprintf('/organization/promotion/%s/delete', $promotionId->getId()),
            RequestMethodInterface::METHOD_POST
        );
    }
}