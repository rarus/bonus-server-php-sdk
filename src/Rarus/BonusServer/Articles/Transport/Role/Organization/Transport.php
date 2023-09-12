<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Articles\Transport\Role\Organization;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\BonusServer\Articles\DTO\Article;
use Rarus\BonusServer\Articles\DTO\ArticleCollection;
use Rarus\BonusServer\Articles\DTO\ArticleFilter;
use Rarus\BonusServer\Articles\DTO\ArticleId;
use Rarus\BonusServer\Articles\DTO\ArticleSegmentFilter;
use Rarus\BonusServer\Articles\Transport\DTO\PaginationResponse;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\Formatters\Pagination;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Articles\Transport\Role\Organization
 */
class Transport extends AbstractTransport
{
    /**
     * Добавление/обновление ассортимента
     *
     * @param ArticleCollection $articleCollection
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function store(ArticleCollection $articleCollection): void
    {
        $this->log->debug(
            'rarus.bonus.server.articles.transport.organization.store.start',
            [
                'count' => $articleCollection->count(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/assortment/batch/add',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Articles\Formatters\Article::toArrayForCreateArticleCollection($articleCollection)
        );
    }

    /**
     * получение ассортимента по id
     *
     * @param ArticleId $articleId
     *
     * @return Article
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getByArticleId(ArticleId $articleId): Article
    {
        $this->log->debug(
            'rarus.bonus.server.articles.transport.organization.getByArticleId.start',
            [
                'articleId' => $articleId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/assortment/get?id=%s', $articleId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $article = \Rarus\BonusServer\Articles\DTO\Fabric::initArticleFromServerResponse($requestResult['assortment']);


        $this->log->debug(
            'rarus.bonus.server.articles.transport.organization.getByArticleId.start',
            [
                'articleId' => $article->getArticleId()->getId(),
            ]
        );

        return $article;
    }

    /**
     * Получение списка ассортимента с фильтрацией и пагинацией
     * @param ArticleFilter                               $articleFilter
     * @param \Rarus\BonusServer\Transport\DTO\Pagination $pagination
     *
     * @return PaginationResponse
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function list(
        ArticleFilter $articleFilter,
        \Rarus\BonusServer\Transport\DTO\Pagination $pagination
    ): PaginationResponse {
        $this->log->debug(
            'rarus.bonus.server.articles.transport.organization.list.start',
            [
                'pageSize'   => $pagination->getPageSize(),
                'pageNumber' => $pagination->getPageNumber(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                '/organization/assortment?%s%s',
                \Rarus\BonusServer\Articles\Formatters\ArticleFilter::toUrlArguments($articleFilter),
                Pagination::toRequestUri($pagination)
            ),
            RequestMethodInterface::METHOD_GET
        );

        $articleCollection = new ArticleCollection();
        foreach ($requestResult['assortment'] as $article) {
            $articleCollection->attach(\Rarus\BonusServer\Articles\DTO\Fabric::initArticleFromServerResponse($article));
        }

        $paginationResponse = new PaginationResponse(
            $articleCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.articles.transport.organization.list.start',
            [
                'itemsCount' => $articleCollection->count(),
            ]
        );

        return $paginationResponse;
    }

    /**
     * Получить список номенклатуры по фильтру
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getBySegmentFilter(
        ArticleSegmentFilter $assortmentSegmentFilter,
        \Rarus\BonusServer\Transport\DTO\Pagination $pagination
    ): PaginationResponse
    {
        $this->log->debug(
            'rarus.bonus.server.articles.transport.organization.getBySegmentFilter.start',
            [
                'pageSize'   => $pagination->getPageSize(),
                'pageNumber' => $pagination->getPageNumber(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/assortment_segment/get_assortment',
            RequestMethodInterface::METHOD_POST,
            [
                'filter_full' => [\Rarus\BonusServer\Articles\Formatters\ArticleFilter::toArrayArticleSegmentFilter($assortmentSegmentFilter)],
                'page' => $pagination->getPageNumber(),
                'per_page' => $pagination->getPageSize(),
                'calculate_count' => true,
            ]
        );

        $articleCollection = new ArticleCollection();
        foreach ($requestResult['assortment_for_segment_items'] as $assortmentForSegmentItem) {
            $articleCollection->attach(\Rarus\BonusServer\Articles\DTO\Fabric::initArticleFromServerResponse($assortmentForSegmentItem));
        }

        $paginationResponse = new PaginationResponse(
            $articleCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.articles.transport.organization.getBySegmentFilter.finish',
            [
                'itemsCount' => $paginationResponse->getArticleCollection()->count(),
            ]
        );

        return $paginationResponse;
    }
}
