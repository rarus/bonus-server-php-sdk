<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transport\DTO;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Transport\DTO
 */
abstract class PaginationResponse
{
    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }
}