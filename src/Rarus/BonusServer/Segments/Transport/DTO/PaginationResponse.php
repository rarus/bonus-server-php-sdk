<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Segments\Transport\DTO;

use Rarus\BonusServer\Segments\DTO\SegmentCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Segments\Transport\DTO
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var SegmentCollection
     */
    private $segmentCollection;

    /**
     * PaginationResponse constructor.
     *
     * @param SegmentCollection $segmentCollection
     * @param Pagination     $pagination
     */
    public function __construct(SegmentCollection $segmentCollection, Pagination $pagination)
    {
        $this->segmentCollection = $segmentCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return SegmentCollection
     */
    public function getSegmentCollection(): SegmentCollection
    {
        return $this->segmentCollection;
    }
}
