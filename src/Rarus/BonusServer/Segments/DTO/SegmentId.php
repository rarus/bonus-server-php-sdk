<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Segments\DTO;

/**
 * Class SegmentId
 *
 * @package Rarus\BonusServer\Segments\DTO
 */
class SegmentId
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
