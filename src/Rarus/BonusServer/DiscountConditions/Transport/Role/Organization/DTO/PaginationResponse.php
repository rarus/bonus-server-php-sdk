<?php

declare(strict_types=1);

namespace Rarus\BonusServer\DiscountConditions\Transport\Role\Organization\DTO;

use Rarus\BonusServer\DiscountConditions\DTO\DiscountConditionCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var DiscountConditionCollection
     */
    private $discountConditionCollection;

    /**
     * @param DiscountConditionCollection $discountCollection
     * @param Pagination $pagination
     */
    public function __construct(DiscountConditionCollection $discountCollection, Pagination $pagination)
    {
        $this->discountConditionCollection = $discountCollection;
        $this->pagination = $pagination;
    }

    public function getDiscountConditionCollection(): DiscountConditionCollection
    {
        return $this->discountConditionCollection;
    }
}
