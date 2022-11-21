<?php

namespace Rarus\BonusServer\Notifications\Transport\Role\User;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Notifications\DTO\Fabric;
use Rarus\BonusServer\Notifications\DTO\NotificationCollection;
use Rarus\BonusServer\Notifications\DTO\NotificationUserFilter;
use Rarus\BonusServer\Notifications\DTO\NotificationId;
use Rarus\BonusServer\Notifications\Formatters\NotificationFilter;
use Rarus\BonusServer\Notifications\Transport\DTO\PaginationResponse;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\DTO\Pagination;

final class Transport extends AbstractTransport
{
    /**
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function list(NotificationUserFilter $filter, Pagination $pagination): PaginationResponse
    {
        $this->log->debug(
            'rarus.bonus.server.notifications.transport.user.list.start',
            [
                'filter'     => NotificationFilter::toUrlArguments($filter),
                'pageSize'   => $pagination->getPageSize(),
                'pageNumber' => $pagination->getPageNumber(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                '/user/notification?%s%s',
                NotificationFilter::toUrlArguments($filter),
                \Rarus\BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
            ),
            RequestMethodInterface::METHOD_GET
        );

        $notificationCollection = new NotificationCollection();
        foreach ($requestResult['notifications'] as $notification) {
            $notificationCollection->attach(Fabric::initNotificationFromServerResponse($notification));
        }

        $paginationResponse = new PaginationResponse(
            $notificationCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.notifications.transport.user.list.finish',
            [
                'itemsCount' => $notificationCollection->count(),
            ]
        );

        return $paginationResponse;
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function read(NotificationId $notificationId): void
    {
        $this->log->debug(
            'rarus.bonus.server.notifications.transport.user.read.start',
            [
                'Id' => $notificationId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/user/notification/%s/check', $notificationId->getId()),
            RequestMethodInterface::METHOD_PUT
        );

        $this->log->debug(
            'rarus.bonus.server.notifications.transport.user.read.finish',
            [
                'request_result' => $requestResult,
            ]
        );
    }
}