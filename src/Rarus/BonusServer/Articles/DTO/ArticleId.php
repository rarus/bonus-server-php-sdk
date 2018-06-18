<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Articles\DTO;

/**
 * Class ArticleId
 *
 * @package Rarus\BonusServer\Articles\DTO
 */
class ArticleId
{
    /**
     * @var string
     */
    private $id;

    /**
     * ArticleId constructor.
     *
     * @param string|null $id
     */
    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}