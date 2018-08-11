<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Level;
/**
 * Class LevelId
 *
 * @package Rarus\BonusServer\Cards\DTO\Level
 */
class LevelId
{
    /**
     * @var string
     */
    private $id;

    /**
     * LevelId constructor.
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