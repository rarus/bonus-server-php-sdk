<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Formatters;

use Rarus\BonusServer\Shops;

/**
 * Class Shop
 *
 * @package Rarus\BonusServer\Shops\Formatters
 */
class Shop
{
    /**
     * @param \Rarus\BonusServer\Shops\DTO\Shop
     *
     * @return array
     */
    public static function toArray(Shops\DTO\Shop $shop): array
    {
        $arSchedule = [];
        foreach ($shop->getSchedule() as $schedule) {
            $arSchedule[] = Schedule::toArray($schedule);
        }

        return [
            'id' => $shop->getShopId()->getId(),
            'name' => $shop->getName(),
            'latitude' => $shop->getLatitude(),
            'longitude' => $shop->getLongitude(),
            'address' => $shop->getAddress(),
            'phone' => $shop->getPhone(),
            'time_zone' => $shop->getTimezoneOffset(),
            'is_deleted' => $shop->isDeleted(),
            'exclude_articles' => $shop->getExcludeArticles(),
            'schedule' => $arSchedule,
        ];
    }

    /**
     * сокращённый набор полей для добавленя нового магазина
     *
     * @param Shops\DTO\Shop $shop
     *
     * @return array
     */
    public static function toArrayForCreateNewShop(Shops\DTO\Shop $shop): array
    {
        return [
            'id' => $shop->getShopId()->getId(),
            'name' => $shop->getName(),
            'latitude' => $shop->getLatitude() ?? 0,
            'longitude' => $shop->getLongitude() ?? 0,
            'address' => $shop->getAddress() ?? '',
            'phone' => $shop->getPhone() ?? '',
            'time_zone' => $shop->getTimezoneOffset() ?? 0,
            'exclude_articles' => $shop->getExcludeArticles() ?? '',
        ];
    }

    /**
     * сокращённый набор полей для обновления информации по магазину
     *
     * @param Shops\DTO\Shop $shop
     *
     * @return array
     */
    public static function toArrayForUpdateShop(Shops\DTO\Shop $shop): array
    {
        return [
            'name' => $shop->getName(),
            'address' => $shop->getAddress() ?? '',
            'latitude' => $shop->getLatitude() ?? 0,
            'longitude' => $shop->getLongitude() ?? 0,
            'phone' => $shop->getPhone() ?? '',
            'time_zone' => $shop->getTimezoneOffset() ?? 0,
            'exclude_articles' => $shop->getExcludeArticles() ?? '',
        ];
    }
}
