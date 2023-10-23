<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Articles\DTO;

use Rarus\BonusServer\Articles\DTO\Property\ArticleProperty;
use Rarus\BonusServer\Articles\DTO\Property\ArticlePropertyCollection;
use Rarus\BonusServer\Articles\DTO\Property\ArticlePropertyId;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Articles\DTO
 */
class Fabric
{
    /**
     * @param array $arArticle
     *
     * @return Article
     */
    public static function initArticleFromServerResponse(array $arArticle): Article
    {
        $articleDate = new \DateTime();
        $articleDate->setTimestamp((int)$arArticle['timestamp']);

        $article = new Article(new ArticleId($arArticle['id']), (string)$arArticle['name']);
        $article
            ->setArticle((string)$arArticle['article'])
            ->setIsGroup((bool)$arArticle['isgroup'])
            ->setDescription((string)$arArticle['description'])
            ->setDeleted((bool)$arArticle['deleted'])
            ->setUploadMobile((bool)$arArticle['unload'])
            ->setDate($articleDate);

        if (\array_key_exists('parent_id', $arArticle) && $arArticle['parent_id']) {
            $article->setParentId(new ArticleId($arArticle['parent_id']));
        }

        if (\array_key_exists('properties', $arArticle) && $arArticle['properties']) {
            $articlePropertyCollection = new ArticlePropertyCollection();
            foreach ($arArticle['properties'] as $property) {
                $articleProperty = new ArticleProperty(
                    new ArticlePropertyId($property['id']),
                    $property['name'],
                    $property['value']
                );
                $articlePropertyCollection->attach($articleProperty);
            }
            $article->setPropertyCollection($articlePropertyCollection);
        }

        if (\array_key_exists('image', $arArticle) && $arArticle['image']) {
            $article->setImage($arArticle['image']);
        }

        return $article;
    }
}
