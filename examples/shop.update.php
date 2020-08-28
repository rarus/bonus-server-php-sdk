<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Shops;

// инициализируем транспорт для работы с сущностью Магазины
$shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newShop = Rarus\BonusServer\Shops\DTO\Fabric::createNewInstance('Новый магазин для обновления');

$shop = $shopTransport->add($newShop);
var_dump(Shops\Formatters\Shop::toArray($shop));

$shop->setName('Поменяли имя магазину');

// изменение расписания
$scheduleCollection = new Shops\DTO\ScheduleCollection();
$schedule = (new Shops\DTO\Schedule())
    ->setDayStart(1)
    ->setDayEnd(5)
    ->setTimeStart(123234)
    ->setTimeEnd(323234)
    ->setIsOpen(true)
;
$scheduleCollection->attach($schedule);
$shop->setSchedule($scheduleCollection);

$updatedShop = $shopTransport->update($shop);

var_dump(Shops\Formatters\Shop::toArray($updatedShop));
