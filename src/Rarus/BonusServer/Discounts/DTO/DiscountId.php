<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

/**
 * Class DiscountId
 *
 * @package Rarus\BonusServer\Discounts\DTO
 */
class DiscountId
{
    /**
     * @var string
     */
    private $id;

    /**
     * CardId constructor.
     *
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}