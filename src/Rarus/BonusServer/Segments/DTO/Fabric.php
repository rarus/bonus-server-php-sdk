<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Segments\DTO;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Segments\DTO
 */
class Fabric
{
    /**
     * @param array $arSegment
     *
     * @return Segment
     */
    public static function initSegmentFromServerResponse(array $arSegment): Segment
    {
        $segment = (new Segment())
            ->setSegmentId(new SegmentId($arSegment['id']))
            ->setName((string)$arSegment['name'])
            ->setIsGroup((bool)$arSegment['isgroup'])
            ->setMaxPaymentPercent((int)$arSegment['max_payment_percent']);

        if (key_exists('parent_id', $arSegment) && $arSegment['parent_id']) {
            $segment->setParentId(new SegmentId($arSegment['parent_id']));
        }

        return $segment;
    }
}
