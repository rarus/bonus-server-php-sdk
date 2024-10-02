<?php

declare(strict_types=1);

namespace Rarus\BonusServer\CouponHolds\Transport\Role\Organization\DTO;

use Rarus\BonusServer\CouponHolds\DTO\CouponHoldCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var CouponHoldCollection
     */
    private $couponHoldCollection;

    /**
     * @param CouponHoldCollection $couponHoldCollection
     * @param Pagination $pagination
     */
    public function __construct(CouponHoldCollection $couponHoldCollection, Pagination $pagination)
    {
        $this->couponHoldCollection = $couponHoldCollection;
        $this->pagination = $pagination;
    }

    public function getCouponHoldCollection(): CouponHoldCollection
    {
        return $this->couponHoldCollection;
    }
}
