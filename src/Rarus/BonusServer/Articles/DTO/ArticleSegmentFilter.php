<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Articles\DTO;

final class ArticleSegmentFilter
{
    /**
     * @var ArticleSegmentFilterProperty|null
     */
    private $property_value;

    /**
     * @var ArticleSegmentFilterProperty | null
     */
    private $parent_id;

    /**
     * @var ArticleSegmentFilterProperty | null
     */
    private $parent_id_hierarchy;

    /**
     * @var ArticleSegmentFilterProperty | null
     */
    private $included_in_segment;

    /**
     * @var ArticleSegmentFilterProperty | null
     */
    private $excluded_in_segment;

    /**
     * @var array | null
     */
    private $included_in_segment_items;
    /**
     * @var array | null
     */
    private $excluded_in_segment_items;
    /**
     * @var array | null
     */
    private $parent_id_hierarchy_items;

    /**
     * @return ArticleSegmentFilterProperty|null
     */
    public function getPropertyValue(): ?ArticleSegmentFilterProperty
    {
        return $this->property_value;
    }

    /**
     * @param ArticleSegmentFilterProperty|null $property_value
     * @return ArticleSegmentFilter
     */
    public function setPropertyValue(?ArticleSegmentFilterProperty $property_value): ArticleSegmentFilter
    {
        $this->property_value = $property_value;
        return $this;
    }

    /**
     * @return ArticleSegmentFilterProperty|null
     */
    public function getParentId(): ?ArticleSegmentFilterProperty
    {
        return $this->parent_id;
    }

    /**
     * @param ArticleSegmentFilterProperty|null $parent_id
     * @return ArticleSegmentFilter
     */
    public function setParentId(?ArticleSegmentFilterProperty $parent_id): ArticleSegmentFilter
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    /**
     * @return ArticleSegmentFilterProperty|null
     */
    public function getParentIdHierarchy(): ?ArticleSegmentFilterProperty
    {
        return $this->parent_id_hierarchy;
    }

    /**
     * @param ArticleSegmentFilterProperty|null $parent_id_hierarchy
     * @return ArticleSegmentFilter
     */
    public function setParentIdHierarchy(?ArticleSegmentFilterProperty $parent_id_hierarchy): ArticleSegmentFilter
    {
        $this->parent_id_hierarchy = $parent_id_hierarchy;
        return $this;
    }

    /**
     * @return ArticleSegmentFilterProperty|null
     */
    public function getIncludedInSegment(): ?ArticleSegmentFilterProperty
    {
        return $this->included_in_segment;
    }

    /**
     * @param ArticleSegmentFilterProperty|null $included_in_segment
     * @return ArticleSegmentFilter
     */
    public function setIncludedInSegment(?ArticleSegmentFilterProperty $included_in_segment): ArticleSegmentFilter
    {
        $this->included_in_segment = $included_in_segment;
        return $this;
    }

    /**
     * @return ArticleSegmentFilterProperty|null
     */
    public function getExcludedInSegment(): ?ArticleSegmentFilterProperty
    {
        return $this->excluded_in_segment;
    }

    /**
     * @param ArticleSegmentFilterProperty|null $excluded_in_segment
     * @return ArticleSegmentFilter
     */
    public function setExcludedInSegment(?ArticleSegmentFilterProperty $excluded_in_segment): ArticleSegmentFilter
    {
        $this->excluded_in_segment = $excluded_in_segment;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getIncludedInSegmentItems(): ?array
    {
        return $this->included_in_segment_items;
    }

    /**
     * @param array|null $included_in_segment_items
     * @return ArticleSegmentFilter
     */
    public function setIncludedInSegmentItems(?array $included_in_segment_items): ArticleSegmentFilter
    {
        $this->included_in_segment_items = $included_in_segment_items;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getExcludedInSegmentItems(): ?array
    {
        return $this->excluded_in_segment_items;
    }

    /**
     * @param array|null $excluded_in_segment_items
     * @return ArticleSegmentFilter
     */
    public function setExcludedInSegmentItems(?array $excluded_in_segment_items): ArticleSegmentFilter
    {
        $this->excluded_in_segment_items = $excluded_in_segment_items;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getParentIdHierarchyItems(): ?array
    {
        return $this->parent_id_hierarchy_items;
    }

    /**
     * @param array|null $parent_id_hierarchy_items
     * @return ArticleSegmentFilter
     */
    public function setParentIdHierarchyItems(?array $parent_id_hierarchy_items): ArticleSegmentFilter
    {
        $this->parent_id_hierarchy_items = $parent_id_hierarchy_items;
        return $this;
    }
}
