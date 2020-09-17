<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Segments\Formatters;

/**
 * Class Segment
 *
 * @package Rarus\BonusServer\Segments\Formatters
 */
class Segment
{
    /**
     * @param \Rarus\BonusServer\Segments\DTO\Segment $segment
     *
     * @return array
     */
    public static function toArray(\Rarus\BonusServer\Segments\DTO\Segment $segment): array
    {
        return [
            'id'                  => $segment->getSegmentId() !== null ? $segment->getSegmentId()->getId() : null,
            'parent_id'           => $segment->getParentId(),
            'name'                => $segment->getName(),
            'max_payment_percent' => $segment->getMaxPaymentPercent(),
            'isgroup'             => $segment->isGroup()
        ];
    }

    /**
     * @param \Rarus\BonusServer\Segments\DTO\Segment $segment
     *
     * @return array
     */
    public static function toArrayForUpdateSegment(\Rarus\BonusServer\Segments\DTO\Segment $segment): array
    {
        return [
            'name'                => $segment->getName(),
            'max_payment_percent' => $segment->getMaxPaymentPercent()
        ];
    }
}
