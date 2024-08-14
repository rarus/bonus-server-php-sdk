<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\Transport\Role\Organization;

use Rarus\BonusServer;
use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Holds\DTO\HoldFilter;
use Rarus\BonusServer\Holds\Formatters\Hold;
use Rarus\BonusServer\Holds\Transport\Role\DTO\PaginationResponse;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Cards\Transport\Role\User
 */
class Transport extends BonusServer\Transport\AbstractTransport
{
    /**
     * Получить список заморозок баллов
     *
     * @param HoldFilter $holdFilter
     * @param Pagination $pagination
     * @return PaginationResponse
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function list(
        HoldFilter $holdFilter,
        Pagination $pagination
    ): BonusServer\Holds\Transport\Role\DTO\PaginationResponse {
        $this->log->debug('rarus.bonus.server.hold.transport.list.start', [
            'pagination' => [
                'pageNumber' => $pagination->getPageNumber(),
                'pageSize' => $pagination->getPageSize(),
            ],
        ]);

        $url = sprintf(
            '/organization/hold?%s%s&calculate_count=true',
            Hold::toUrlArguments($holdFilter),
            BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
        );

        $requestResult = $this->apiClient->executeApiRequest(
            $url,
            RequestMethodInterface::METHOD_GET
        );

        $holdCollection = new BonusServer\Holds\DTO\HoldCollection();
        foreach ((array)$requestResult['holds'] as $hold) {
            $holdCollection->attach(BonusServer\Holds\DTO\Fabric::initHoldFromServerResponse($hold, $this->apiClient->getTimezone()));
        }

        $paginationResponse = new PaginationResponse(
            $holdCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug('rarus.bonus.server.hold.transport.list.finish', [
            'itemsCount' => $holdCollection->count(),
        ]);

        return $paginationResponse;
    }

    /**
     * Получить заморозку баллов
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getById(BonusServer\Holds\DTO\HoldId $holdId): BonusServer\Holds\DTO\Hold
    {
        $this->log->debug('rarus.bonus.server.hold.transport.getById.start', [
            'hold_id' => $holdId->getId(),
        ]);

        $url = sprintf(
            '/organization/hold/%s',
            $holdId->getId()
        );

        $requestResult = $this->apiClient->executeApiRequest(
            $url,
            RequestMethodInterface::METHOD_GET
        );

        if (empty($requestResult['hold'])) {
            throw new ApiClientException('hold is empty');
        }

        $hold = BonusServer\Holds\DTO\Fabric::initHoldFromServerResponse($requestResult['hold'], $this->apiClient->getTimezone());

        $this->log->debug('rarus.bonus.server.hold.transport.getById.finish', [
            'hold_id' => $hold->getHoldId()->getId(),
        ]);

        return $hold;
    }

    /**
     * Добавить заморозку баллов
     * @param BonusServer\Holds\DTO\NewHold $hold
     * @return BonusServer\Holds\DTO\HoldId
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function add(BonusServer\Holds\DTO\NewHold $hold): BonusServer\Holds\DTO\HoldId
    {
        $this->log->debug(
            'rarus.bonus.server.hold.transport.add.start',
            BonusServer\Holds\Formatters\NewHold::toArray($hold)
        );

        $requestData = BonusServer\Holds\Formatters\NewHold::toArray($hold);

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/hold/add',
            RequestMethodInterface::METHOD_POST,
            $requestData
        );

        $holdId = new BonusServer\Holds\DTO\HoldId($requestResult['id']);

        $this->log->debug('rarus.bonus.server.hold.transport.add.finish', [
            'id' => $holdId->getId()
        ]);

        return $holdId;
    }

    /**
     * Удалить заморозку баллов
     * @throws NetworkException
     * @throws ApiClientException
     * @throws UnknownException
     */
    public function delete(BonusServer\Holds\DTO\HoldId $holdId): void
    {
        $this->log->debug(
            'rarus.bonus.server.hold.transport.delete.start',
            [
                'id' => $holdId->getId()
            ]
        );

        $this->apiClient->executeApiRequest(
            sprintf('/organization/hold/%s/delete', $holdId->getId()),
            RequestMethodInterface::METHOD_POST
        );
    }
}
