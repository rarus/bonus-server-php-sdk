<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO;

/**
 * Class CardId
 *
 * @package Rarus\BonusServer\Cards\DTO
 */
class CardId
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
