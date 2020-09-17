<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Segments\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Segments\DTO\Fabric;
use Rarus\BonusServer\Segments\DTO\Segment;
use Rarus\BonusServer\Segments\DTO\SegmentCollection;
use Rarus\BonusServer\Segments\DTO\SegmentId;
use Rarus\BonusServer\Segments\Transport\DTO\PaginationResponse;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\Formatters\Pagination;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Segments\Transport\Role\Organization
 */
class Transport extends AbstractTransport
{
    public function addNewSegment(Segment $newSegment): Segment
    {
        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.addNewSegment.start',
            [
                'name'      => $newSegment->getName(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/segment/add',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Segments\Formatters\Segment::toArray($newSegment)
        );

        // вычитываем сегмент с сервера
        $segment = $this->getBySegmentId(new SegmentId($requestResult['id']));

        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.addNewSegment.finish',
            [
                'segmentId' => $segment->getSegmentId()->getId(),
                'name'      => $segment->getName(),
            ]
        );

        return $segment;
    }

    /**
     * @param SegmentId $segmentId
     *
     * @return Segment
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getBySegmentId(SegmentId $segmentId): Segment
    {
        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.getBySegmentId.start',
            [
                'segmentId' => $segmentId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/segment/%s', $segmentId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $segment = Fabric::initSegmentFromServerResponse($requestResult['segment']);


        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.getBySegmentId.start',
            [
                'segmentId' => $segmentId->getId(),
            ]
        );

        return $segment;
    }

    /**
     * @param Segment $segment
     *
     * @return Segment
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function update(Segment $segment): Segment
    {
        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.update.start',
            [
                'segmentId' => $segment->getSegmentId()->getId(),
                'name'      => $segment->getName(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/segment/%s', $segment->getSegmentId()->getId()),
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Segments\Formatters\Segment::toArrayForUpdateSegment($segment)
        );

        $updatedSegment = $this->getBySegmentId($segment->getSegmentId());

        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.update.start',
            [
                'segmentId' => $updatedSegment->getSegmentId()->getId(),
                'name'      => $updatedSegment->getName(),
            ]
        );

        return $updatedSegment;
    }

    /**
     * @param Segment $segment
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function delete(Segment $segment): void
    {
        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.delete.start',
            [
                'segmentId' => $segment->getSegmentId()->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/segment/%s/delete', $segment->getSegmentId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.delete.finish',
            [
                'segmentId' => $segment->getSegmentId()->getId(),
            ]
        );
    }

    /**
     * @param \Rarus\BonusServer\Transport\DTO\Pagination $pagination
     *
     * @return PaginationResponse
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function list(\Rarus\BonusServer\Transport\DTO\Pagination $pagination): PaginationResponse
    {
        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.list.start',
            [
                'pageSize'   => $pagination->getPageSize(),
                'pageNumber' => $pagination->getPageNumber(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/segment?%s', Pagination::toRequestUri($pagination)),
            RequestMethodInterface::METHOD_GET
        );

        $segmentCollection = new SegmentCollection();
        foreach ($requestResult['segments'] as $segment) {
            $segmentCollection->attach(Fabric::initSegmentFromServerResponse($segment));
        }

        $paginationResponse = new PaginationResponse(
            $segmentCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.segments.transport.organization.list.start',
            [
                'itemsCount' => $segmentCollection->count(),
            ]
        );

        return $paginationResponse;
    }
}
