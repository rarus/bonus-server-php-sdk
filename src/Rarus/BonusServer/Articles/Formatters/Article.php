<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Articles\Formatters;

use Rarus\BonusServer\Articles\DTO\ArticleCollection;

/**
 * Class Article
 *
 * @package Rarus\BonusServer\Articles\Formatters
 */
class Article
{
    /**
     * @param \Rarus\BonusServer\Articles\DTO\Article $article
     *
     * @return array
     */
    public static function toArray(\Rarus\BonusServer\Articles\DTO\Article $article): array
    {
        $arProperties = [];
        foreach ($article->getPropertyCollection() as $property) {
            $arProperties[] = [
                'id'    => $property->getPropertyId()->getId(),
                'name'  => $property->getName(),
                'value' => $property->getValue()
            ];
        }

        return [
            'id'          => $article->getArticleId()->getId(),
            'parent_id'   => $article->getParentId() !== null ? $article->getParentId()->getId() : null,
            'name'        => $article->getName(),
            'description' => $article->getDescription(),
            'isgroup'     => (bool)$article->isGroup(),
            'properties'  => $arProperties,
            'unload'      => (bool)$article->isUploadMobile(),
            'deleted'     => (bool)$article->isDeleted(),
        ];
    }

    /**
     * @param ArticleCollection $articleCollection
     *
     * @return array[]
     */
    public static function toArrayForCreateArticleCollection(ArticleCollection $articleCollection): array
    {
        $arArticleCollection = [];
        foreach ($articleCollection as $article) {
            $arArticleCollection[] = self::toArray($article);
        }

        return [
            'assortment' => $arArticleCollection
        ];
    }

    /**
     * @param \Rarus\BonusServer\Articles\DTO\Article $article
     *
     * @return array
     */
    public static function toArrayForUpdateArticle(\Rarus\BonusServer\Articles\DTO\Article $article): array
    {
        return [
            'name'        => $article->getName(),
            'description' => $article->getDescription()
        ];
    }
}
