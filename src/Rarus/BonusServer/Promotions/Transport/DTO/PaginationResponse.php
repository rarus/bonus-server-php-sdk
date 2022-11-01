<?php

namespace Rarus\BonusServer\Promotions\Transport\DTO;

use Rarus\BonusServer\Promotions\DTO\PromotionCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var \Rarus\BonusServer\Promotions\DTO\PromotionCollection
     */
    private $promotionCollection;

    /**
     * @param \Rarus\BonusServer\Promotions\DTO\PromotionCollection $promotionCollection
     * @param \Rarus\BonusServer\Transport\DTO\Pagination           $pagination
     */
    public function __construct(PromotionCollection $promotionCollection, Pagination $pagination)
    {
        $this->promotionCollection = $promotionCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return \Rarus\BonusServer\Promotions\DTO\PromotionCollection
     */
    public function getPromotionCollection(): PromotionCollection
    {
        return $this->promotionCollection;
    }
}
