<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Transport\Role\Organization;

use Rarus\BonusServer\Discounts;
use Rarus\BonusServer;
use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Transport\Formatters\Pagination;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Transactions\Transport
 */
class Transport extends BonusServer\Transport\AbstractTransport
{

    /**
     * @param Discounts\DTO\Document $discountDocument
     *
     * @return null|Discounts\DTO\Estimate
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function calculateDiscounts(BonusServer\Discounts\DTO\Document $discountDocument): ?Discounts\DTO\Estimate
    {
        $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscounts.start', [
            'role' => 'organization',
        ]);

        $estimate = null;
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                '/organization/calculate_document',
                RequestMethodInterface::METHOD_POST,
                Discounts\Formatters\Document::toArray($discountDocument)
            );

            $estimate = Discounts\DTO\Fabric::initEstimateFromServerResponse($this->getDefaultCurrency(), $requestResult);
            $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscounts.finish', [
                'documentItemsCount' => $estimate->getDocumentItems()->count(),
                'discountItemsCount' => $estimate->getDiscountItems()->count(),
            ]);
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если скидки не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

        return $estimate;
    }

    /**
     * Метод вызывается для расчёта скидки на товар для вывода на витрине. При вызове выполняется расчет суммовых и подарочных скидок.
     * Метод возвращает список примененных к строкам чека скидок и рассчитанный документ, производится рассчёт бонусных скидок
     *
     * @param Discounts\DTO\Document $discountDocument
     *
     * @return null|Discounts\DTO\Estimate
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function calculateDiscountsAndBonusDiscounts(BonusServer\Discounts\DTO\Document $discountDocument): ?Discounts\DTO\Estimate
    {
        $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscountsAndBonusDiscounts.start', [
            'role' => 'organization',
        ]);
        $estimate = null;
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                '/organization/calculate',
                RequestMethodInterface::METHOD_POST,
                Discounts\Formatters\Document::toArray($discountDocument)
            );

            $estimate = Discounts\DTO\Fabric::initEstimateFromServerResponse($this->getDefaultCurrency(), $requestResult);
            $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscountsAndBonusDiscounts.finish', [
                'documentItemsCount' => $estimate->getDocumentItems()->count(),
                'discountItemsCount' => $estimate->getDiscountItems()->count(),
            ]);
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если скидки не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

        return $estimate;
    }

    /**
     * Получить список скидок
     * @param Discounts\DTO\DiscountFilter $discountFilter
     * @param BonusServer\Transport\DTO\Pagination|null $pagination
     * @return Discounts\Transport\Role\DTO\PaginationResponse
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getByFilter(
        Discounts\DTO\DiscountFilter $discountFilter,
        ?BonusServer\Transport\DTO\Pagination $pagination
    ): Discounts\Transport\Role\DTO\PaginationResponse
    {
        $this->log->debug('rarus.bonus.server.Discounts.transport.getByFilter.start', [
            'pagination' => $pagination === null ? null : [
                'pageNumber' => $pagination->getPageNumber(),
                'pageSize' => $pagination->getPageSize(),
            ],
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                '/organization/discount?%s%s',
                Discounts\Formatters\DiscountFilter::toUrlArguments($discountFilter),
                Pagination::toRequestUri($pagination)
            ),
            RequestMethodInterface::METHOD_GET
        );

        $discountCollection = new Discounts\DTO\DiscountCollection();
        foreach ($requestResult['discounts'] as $discount) {
            $discountCollection->attach(Discounts\DTO\Fabric::initFullDiscountFromServerResponse($discount));
        }

        $paginationResponse = new Discounts\Transport\Role\DTO\PaginationResponse(
            $discountCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.Discounts.transport.getByFilter.finish',
            [
                'itemsCount' => $discountCollection->count(),
            ]
        );

        return $paginationResponse;
    }

    /**
     * Получить скидку по ИД
     * @param Discounts\DTO\DiscountId $discountId
     * @param bool $fullInfo
     * @return Discounts\DTO\Discount
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getById(
        Discounts\DTO\DiscountId $discountId,
        bool $fullInfo = false
    ): Discounts\DTO\Discount
    {
        $this->log->debug('rarus.bonus.server.discounts.transport.getById.start', [
            'discountId' => $discountId->getId(),
            'full_info' => $fullInfo
        ]);

        $url = sprintf(
            '/organization/discount/%s?full_info=%s',
            $discountId->getId(),
            $fullInfo ? 'true' : 'false'
        );

        $requestResult = $this->apiClient->executeApiRequest(
            $url,
            RequestMethodInterface::METHOD_GET
        );

        $discount = Discounts\DTO\Fabric::initFullDiscountFromServerResponse($requestResult['discount']);

        $this->log->debug(
            'rarus.bonus.server.discounts.transport.getById.finish',
            [
                'discountId' => $discount->getId(),
            ]
        );

        return $discount;
    }
}
