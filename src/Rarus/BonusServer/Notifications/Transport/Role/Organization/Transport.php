<?php

namespace Rarus\BonusServer\Notifications\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Notifications\DTO\Fabric;
use Rarus\BonusServer\Notifications\DTO\NewNotification;
use Rarus\BonusServer\Notifications\DTO\Notification;
use Rarus\BonusServer\Notifications\DTO\NotificationCollection;
use Rarus\BonusServer\Notifications\DTO\NotificationId;
use Rarus\BonusServer\Notifications\DTO\NotificationOrganizationFilter;
use Rarus\BonusServer\Notifications\Formatters\NotificationFilter;
use Rarus\BonusServer\Notifications\Transport\DTO\PaginationResponse;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\DTO\Pagination;

class Transport extends AbstractTransport
{
    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function add(NewNotification $newNotification): Notification
    {
        $this->log->debug(
            'rarus.bonus.server.notifications.transport.organization.add.start',
            \Rarus\BonusServer\Notifications\Formatters\NewNotification::toArray($newNotification)
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/notification',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Notifications\Formatters\NewNotification::toArray($newNotification)
        );

        $createdNotification = $this->getById(new NotificationId($requestResult['id']));

        $this->log->debug(
            'rarus.bonus.server.notifications.transport.organization.add.finish',
            $requestResult
        );

        return $createdNotification;
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function getById(NotificationId $notificationId): Notification
    {
        $this->log->debug(
            'rarus.bonus.server.notifications.transport.organization.getById.start',
            ['id' => $notificationId->getId()]
        );

        $organizationFilter = new NotificationOrganizationFilter();
        $organizationFilter->setNotificationId(new NotificationId($notificationId->getId()));
        $notificationCollection = $this->list($organizationFilter, new Pagination())->getNotificationCollection();
        $notification = $notificationCollection->current();

        $this->log->debug(
            'rarus.bonus.server.notifications.transport.organization.getById.finish',
            [
                'id' => $notification->getNotificationId()->getId()
            ]
        );

        return $notification;
    }

    /**
     * @param \Rarus\BonusServer\Notifications\DTO\NotificationOrganizationFilter $filter
     * @param \Rarus\BonusServer\Transport\DTO\Pagination                         $pagination
     *
     * @return \Rarus\BonusServer\Notifications\Transport\DTO\PaginationResponse
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function list(NotificationOrganizationFilter $filter, Pagination $pagination): PaginationResponse
    {
        $this->log->debug(
            'rarus.bonus.server.notifications.transport.organization.list.start',
            [
                'filter'     => NotificationFilter::toUrlArgumentsFromOrganization($filter),
                'pageSize'   => $pagination->getPageSize(),
                'pageNumber' => $pagination->getPageNumber(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                '/organization/notification?%s%s',
                NotificationFilter::toUrlArgumentsFromOrganization($filter),
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
            'rarus.bonus.server.notifications.transport.organization.list.finish',
            [
                'itemsCount' => $notificationCollection->count(),
            ]
        );

        return $paginationResponse;
    }
}