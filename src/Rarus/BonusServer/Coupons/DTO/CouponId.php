<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Coupons\DTO;

/**
 * Class CouponId
 *
 * @package Rarus\BonusServer\Coupons\DTO
 */
class CouponId
{
    /**
     * @var string
     */
    private $id;

    /**
     * CouponId constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
