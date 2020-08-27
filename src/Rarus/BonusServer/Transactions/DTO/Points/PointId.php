<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points;

/**
 * Class PointId
 *
 * @package Rarus\BonusServer\Transactions\DTO\Points
 */
class PointId
{
    /**
     * @var string
     */
    private $id;

    /**
     * PointId constructor.
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
