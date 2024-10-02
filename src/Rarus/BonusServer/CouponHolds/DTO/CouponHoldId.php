<?php

declare(strict_types=1);


namespace Rarus\BonusServer\CouponHolds\DTO;

/**
 * Class CouponId
 *
 * @package Rarus\BonusServer\CouponHolds\DTO
 */
class CouponHoldId
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
