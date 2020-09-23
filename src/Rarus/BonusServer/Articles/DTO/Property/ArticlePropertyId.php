<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Articles\DTO\Property;

/**
 * Class LevelId
 *
 * @package Rarus\BonusServer\Articles\DTO\Property
 */
class ArticlePropertyId
{
    /**
     * @var string
     */
    private $id;

    /**
     * ArticlePropertyId constructor.
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
