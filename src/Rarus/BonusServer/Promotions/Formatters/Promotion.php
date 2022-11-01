<?php

namespace Rarus\BonusServer\Promotions\Formatters;

class Promotion
{
    public static function toArray(\Rarus\BonusServer\Promotions\DTO\Promotion $promotion): array
    {
        $arPromotion = [
            'id'                => $promotion->getPromotionId()->getId(),
            'start_date'        => $promotion->getStartDate() ? $promotion->getStartDate()->getTimestamp() : 0,
            'end_date'          => $promotion->getEndDate() ? $promotion->getEndDate()->getTimestamp() : 0,
            'shop_id'           => $promotion->getShopId() ?? null,
            'name'              => $promotion->getName() ?? '',
            'short_description' => $promotion->getShortDescription() ?? '',
            'full_description'  => $promotion->getFullDescription() ?? '',
            'promo_url'         => $promotion->getPromoUrl() ?? null,
            'text_type'         => $promotion->getTextType(),
            'priority'          => $promotion->getPriority(),
        ];

        if ($promotion->getPropertyCollection()) {
            foreach ($promotion->getPropertyCollection() as $property) {
                if (!in_array($property->getName(), $arPromotion)) {
                    $arPromotion[$property->getName()] = $property->getValue();
                }
            }
        }

        return $arPromotion;
    }
}