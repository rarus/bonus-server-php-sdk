<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Articles\Transport\DTO;

use Rarus\BonusServer\Articles\DTO\ArticleCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Articles\Transport\DTO
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var ArticleCollection
     */
    private $articleCollection;

    /**
     * PaginationResponse constructor.
     *
     * @param ArticleCollection $ArticleCollection
     * @param Pagination        $pagination
     */
    public function __construct(ArticleCollection $ArticleCollection, Pagination $pagination)
    {
        $this->articleCollection = $ArticleCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return ArticleCollection
     */
    public function getArticleCollection(): ArticleCollection
    {
        return $this->articleCollection;
    }
}
