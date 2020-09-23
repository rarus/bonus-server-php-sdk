<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Articles\Formatters;

use Rarus\BonusServer;

/**
 * Class ArticleFilter
 *
 * @package Rarus\BonusServer\Articles\Formatters
 */
class ArticleFilter
{
    /**
     * @param BonusServer\Articles\DTO\ArticleFilter $articleFilter
     *
     * @return string
     */
    public static function toUrlArguments(BonusServer\Articles\DTO\ArticleFilter $articleFilter): string
    {
        $arFilter = [];
        if ($articleFilter->getArticleId()) {
            $arFilter['id'] = $articleFilter->getArticleId()->getId();
        }
        if ($articleFilter->getParentId()) {
            $arFilter['parent_id'] = $articleFilter->getParentId()->getId();
        }
        if ($articleFilter->getNameFilter() !== '') {
            $arFilter['name_filter'] = $articleFilter->getNameFilter();
        }
        if ($articleFilter->getWithGroups()) {
            $arFilter['with_groups'] = $articleFilter->getWithGroups();
        }
        if ($articleFilter->getPropertyId()) {
            $arFilter['property_id'] = $articleFilter->getPropertyId()->getId();
        }
        if ($articleFilter->getPropertyValue()) {
            $arFilter['property_value'] = $articleFilter->getPropertyValue()->getValue();
        }
        return http_build_query($arFilter);
    }
}
