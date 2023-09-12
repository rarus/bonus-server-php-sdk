<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Articles\Formatters;

use Rarus\BonusServer;
use Rarus\BonusServer\Articles\DTO\ArticleSegmentFilter;

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

    public static function toArrayArticleSegmentFilter(ArticleSegmentFilter $assortmentSegmentFilter): array
    {
        $arFilter = [];

        if (!empty($assortmentSegmentFilter->getPropertyValue())) {
            $arFilter['property_value'] = [
                'id' => $assortmentSegmentFilter->getPropertyValue()->getId() ?? '',
                'value' => $assortmentSegmentFilter->getPropertyValue()->getValue(),
                'operator' => $assortmentSegmentFilter->getPropertyValue()->getOperator(),
            ];
        }

        if (!empty($assortmentSegmentFilter->getParentId())) {
            $arFilter['parent_id'] = [
                'value' => $assortmentSegmentFilter->getParentId()->getValue(),
                'operator' => $assortmentSegmentFilter->getParentId()->getOperator(),
            ];
        }

        if (!empty($assortmentSegmentFilter->getParentIdHierarchy())) {
            $arFilter['parent_id_hierarchy'] = [
                'value' => $assortmentSegmentFilter->getParentIdHierarchy()->getValue(),
                'operator' => $assortmentSegmentFilter->getParentIdHierarchy()->getOperator(),
            ];
        }

        if (!empty($assortmentSegmentFilter->getIncludedInSegment())) {
            $arFilter['included_in_segment'] = [
                'value' => $assortmentSegmentFilter->getIncludedInSegment()->getValue(),
                'operator' => $assortmentSegmentFilter->getIncludedInSegment()->getOperator(),
            ];
        }

        if (!empty($assortmentSegmentFilter->getExcludedInSegment())) {
            $arFilter['excluded_in_segment'] = [
                'value' => $assortmentSegmentFilter->getExcludedInSegment()->getValue(),
                'operator' => $assortmentSegmentFilter->getExcludedInSegment()->getOperator(),
            ];
        }

        return $arFilter;

    }
}
