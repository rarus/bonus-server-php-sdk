<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Coupons\Transport\Role\Organization\DTO;

use Rarus\BonusServer\Coupons\DTO\CouponGroupCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var CouponGroupCollection
     */
    private $couponGroupCollection;

    /**
     * @param CouponGroupCollection $couponGroupCollection
     * @param Pagination $pagination
     */
    public function __construct(CouponGroupCollection $couponGroupCollection, Pagination $pagination)
    {
        $this->couponGroupCollection = $couponGroupCollection;
        $this->pagination = $pagination;
    }

    public function getCouponGroupCollection(): CouponGroupCollection
    {
        return $this->couponGroupCollection;
    }
}
