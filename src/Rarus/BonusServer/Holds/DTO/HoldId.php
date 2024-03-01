<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\DTO;

final class HoldId
{
    /**
     * @var string
     */
    private $id;

    /**
     * CardId constructor.
     *
     * @param string|null $id
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
