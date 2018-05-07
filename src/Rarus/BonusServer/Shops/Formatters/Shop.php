<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Formatters;

use \Rarus\BonusServer\Shops;

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
            'id' => $shop->getId(),
            'name' => $shop->getName(),
            'latitude' => $shop->getLatitude(),
            'longitude' => $shop->getLongitude(),
            'address' => $shop->getAddress(),
            'phone' => $shop->getPhone(),
            'time_zone' => $shop->getTimeZone()->getName(),
            'is_deleted' => $shop->isDeleted(),
            'schedule' => $arSchedule,
        ];
    }
}