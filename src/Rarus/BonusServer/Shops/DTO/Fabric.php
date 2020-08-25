<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Shops\DTO;

use Rarus\BonusServer\Exceptions\ApiClientException;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Shops
 */
class Fabric
{
    /**
     * @param string $shopName
     *
     * @return Shop
     */
    public static function createNewInstance(string $shopName): Shop
    {
        return (new Shop())
            ->setShopId(new ShopId())
            ->setName($shopName)
            ->setTimezoneOffset(0)
            ->setIsDeleted(false);
    }

    /**
     * @param array $arShop
     *
     * @return \Rarus\BonusServer\Shops\DTO\Shop
     * @throws ApiClientException
     */
    public static function initShopFromServerResponse(array $arShop): Shop
    {
        $scheduleCollection = new ScheduleCollection();

        if (key_exists('schedule', $arShop)) {
            foreach ((array)$arShop['schedule'] as $arSchedule) {
                $scheduleCollection->attach(self::initScheduleFromServerResponse($arSchedule));
            }
        }

        $shop = new Shop();
        $shop
            ->setShopId(new ShopId($arShop['id']))
            ->setName($arShop['name'])
            ->setLatitude((float)$arShop['latitude'])
            ->setLongitude((float)$arShop['longitude'])
            ->setAddress($arShop['address'])
            ->setPhone($arShop['phone'])
            ->setIsDeleted($arShop['deleted'])
            ->setExcludeArticles($arShop['exclude_articles'])
            ->setTimezoneOffset((int)$arShop['time_zone'])
            ->setSchedule($scheduleCollection);

        return $shop;
    }

    /**
     * @param array $arSchedule
     *
     * @return Schedule
     * @throws ApiClientException
     */
    public static function initScheduleFromServerResponse(array $arSchedule): Schedule
    {
        $schedule = (new Schedule())
            ->setDayStart((int)$arSchedule['day_start'])
            ->setDayEnd((int)$arSchedule['day_end'])
            ->setTimeStart((int)$arSchedule['time_start'])
            ->setTimeEnd((int)$arSchedule['time_end']);
        switch (strtolower($arSchedule['status'])) {
            case 'open':
                $schedule->setIsOpen(true);
                break;
            case 'closed':
                $schedule->setIsOpen(false);
                break;
            default:
                throw new ApiClientException(sprintf('неизвестный статус работы магазина [%s]', strtolower($arSchedule['status'])));
                break;
        }

        return $schedule;
    }
}