<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transport\DTO;

use Rarus\BonusServer\Exceptions\ApiClientException;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transport\DTO
 */
class Fabric
{
    /**
     * @param array $arPagination
     *
     * @return Pagination
     * @throws ApiClientException
     */
    public static function initPaginationFromServerResponse(array $arPagination): Pagination
    {
        if (!array_key_exists('per_page', $arPagination)) {
            throw new ApiClientException(sprintf('ошибка в структуре объекта постраничной навигации, в отвте сервера нет поля per_page'));
        }
        if (!array_key_exists('page', $arPagination)) {
            throw new ApiClientException(sprintf('ошибка в структуре объекта постраничной навигации, в отвте сервера нет поля page'));
        }
        if (!array_key_exists('items', $arPagination)) {
            throw new ApiClientException(sprintf('ошибка в структуре объекта постраничной навигации, в отвте сервера нет поля items'));
        }
        if (!array_key_exists('pages', $arPagination)) {
            throw new ApiClientException(sprintf('ошибка в структуре объекта постраничной навигации, в отвте сервера нет поля pages'));
        }

        $pagination = new Pagination();
        $pagination
            ->setPageNumber((int)$arPagination['page'])
            ->setPageSize((int)$arPagination['per_page'])
            ->setResultItemsCount((int)$arPagination['items'])
            ->setResultPagesCount((int)$arPagination['pages']);

        return $pagination;
    }
}
