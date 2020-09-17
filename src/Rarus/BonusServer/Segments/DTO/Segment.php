<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Segments\DTO;

/**
 * Class Segment
 *
 * @package Rarus\BonusServer\Segments\DTO
 */
class Segment
{
    /**
     * @var SegmentId Идентификатор сегмента. Если не передан - генерируется сервисом.
     */
    private $segmentId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var SegmentId Идентификатор родительской группы. Если не передан - сегмент создается в корне дерева сегментов
     */
    private $parentId;
    /**
     * @var int
     */
    private $maxPaymentPercent;
    /**
     * @var bool
     */
    private $isGroup;

    /**
     * @return SegmentId
     */
    public function getSegmentId(): ?SegmentId
    {
        return $this->segmentId;
    }

    /**
     * @param SegmentId $segmentId
     */
    public function setSegmentId(SegmentId $segmentId): Segment
    {
        $this->segmentId = $segmentId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): Segment
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return SegmentId|null
     */
    public function getParentId(): ?SegmentId
    {
        return $this->parentId;
    }

    /**
     * @param SegmentId $parentId
     */
    public function setParentId(SegmentId $parentId): Segment
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxPaymentPercent(): ?int
    {
        return $this->maxPaymentPercent;
    }

    /**
     * @param int $maxPaymentPercent
     */
    public function setMaxPaymentPercent(int $maxPaymentPercent): Segment
    {
        $this->maxPaymentPercent = $maxPaymentPercent;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isGroup(): ?bool
    {
        return $this->isGroup;
    }

    /**
     * @param bool $isGroup
     */
    public function setIsGroup(bool $isGroup = true): Segment
    {
        $this->isGroup = $isGroup;

        return $this;
    }
}
