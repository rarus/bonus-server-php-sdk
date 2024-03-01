<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\Transport\Role\DTO;

use Rarus\BonusServer\Holds\DTO\HoldCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Articles\Transport\DTO
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var HoldCollection
     */
    private $holdCollection;

    /**
     * @param HoldCollection $holdCollection
     * @param Pagination $pagination
     */
    public function __construct(HoldCollection $holdCollection, Pagination $pagination)
    {
        $this->holdCollection = $holdCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return HoldCollection
     */
    public function getHoldCollection(): HoldCollection
    {
        return $this->holdCollection;
    }
}
