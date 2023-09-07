<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Transport\Role\DTO;

use Rarus\BonusServer\Discounts\DTO\DiscountCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Articles\Transport\DTO
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var DiscountCollection
     */
    private $discountCollection;

    /**
     * @param DiscountCollection $discountCollection
     * @param Pagination $pagination
     */
    public function __construct(DiscountCollection $discountCollection, Pagination $pagination)
    {
        $this->discountCollection = $discountCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return DiscountCollection
     */
    public function getDiscountCollection(): DiscountCollection
    {
        return $this->discountCollection;
    }
}
