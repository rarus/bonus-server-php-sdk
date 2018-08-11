<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transport\DTO;

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
     */
    public static function initPaginationFromServerResponse(array $arPagination): Pagination
    {
        $pagination = new Pagination();
        $pagination
            ->setPageNumber((int)$arPagination['page'])
            ->setPageSize((int)$arPagination['per_page'])
            ->setResultItemsCount((int)$arPagination['items'])
            ->setResultPagesCount((int)$arPagination['pages']);

        return $pagination;
    }
}