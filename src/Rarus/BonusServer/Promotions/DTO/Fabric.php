<?php

namespace Rarus\BonusServer\Promotions\DTO;

use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transport\DTO\Property;
use Rarus\BonusServer\Transport\DTO\PropertyCollection;

class Fabric
{
    public static function initPromotionFromServerResponse(array $response): Promotion
    {
        $promotion = new Promotion(new PromotionId($response['id']));

        if (!empty($response['start_date'])) {
            $promotion->setStartDate((new \DateTime())->setTimestamp($response['start_date']));
        }

        if (!empty($response['end_date'])) {
            $promotion->setEndDate((new \DateTime())->setTimestamp($response['end_date']));
        }

        if (!empty($response['shop_id'])) {
            $promotion->setShopId(new ShopId($response['shop_id']));
        }

        if (!empty($response['name'])) {
            $promotion->setName($response['name']);
        }

        if (!empty($response['short_description'])) {
            $promotion->setShortDescription($response['short_description']);
        }

        if (!empty($response['full_description'])) {
            $promotion->setFullDescription($response['full_description']);
        }

        if (!empty($response['promo_url'])) {
            $promotion->setPromoUrl($response['promo_url']);
        }

        if (!empty($response['text_type'])) {
            $promotion->setTextType($response['text_type']);
        }

        if (!empty($response['priority'])) {
            $promotion->setPriority($response['priority']);
        }

        if (!empty($response['image'])) {
            $promotion->setImage($response['image']);
        }

        $propertyCollection = new PropertyCollection();
        foreach ($response as $name => $value) {
            $propertyCollection->attach(
                new Property(
                    $name,
                    $value
                )
            );
        }

        return $promotion;
    }
}