<?php

declare(strict_types=1);

namespace Rarus\BonusServer\DiscountConditions\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\DiscountConditions\DTO\DiscountConditionCollection;
use Rarus\BonusServer\DiscountConditions\DTO\DiscountConditionFilter;
use Rarus\BonusServer\DiscountConditions\Formatters\DiscountCondition;
use Rarus\BonusServer\DiscountConditions\Transport\Role\Organization\DTO\PaginationResponse;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\DTO\Pagination;

final class Transport extends AbstractTransport
{
    /**
     * @param DiscountConditionFilter $discountConditionFilter
     * @param Pagination $pagination
     * @return PaginationResponse
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getByFilter(
        DiscountConditionFilter $discountConditionFilter,
        Pagination $pagination
    ): PaginationResponse {
        $this->log->debug('rarus.bonus.server.discountConditions.transport.getByFilter.start', [
            'pagination' => [
                'pageNumber' => $pagination->getPageNumber(),
                'pageSize' => $pagination->getPageSize(),
            ],
        ]);

        $url = sprintf(
            '/organization/discount_condition?%s%s&calculate_count=true',
            DiscountCondition::toUrlArguments($discountConditionFilter),
            \Rarus\BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
        );

        $requestResult = $this->apiClient->executeApiRequest(
            $url,
            RequestMethodInterface::METHOD_GET
        );

        $discountConditionCollection = new DiscountConditionCollection();
        foreach ($requestResult['discount_conditions'] as $discountCondition) {
            $discountConditionCollection->attach(
                \Rarus\BonusServer\DiscountConditions\DTO\Fabric::initDiscountConditionFromServerResponse(
                    $discountCondition
                )
            );
        }

        $paginationResponse = new PaginationResponse(
            $discountConditionCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.discountConditions.transport.getByFilter.finish',
            [
                'itemsCount' => $discountConditionCollection->count(),
            ]
        );

        return $paginationResponse;
    }
}
