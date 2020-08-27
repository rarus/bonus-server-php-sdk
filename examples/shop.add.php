<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Shops;

// инициализируем транспорт для работы с сущностью Магазины
$shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newShop = Rarus\BonusServer\Shops\DTO\Fabric::createNewInstance('Новый магазин');

var_dump(Shops\Formatters\Shop::toArrayForCreateNewShop($newShop));

$shop = $shopTransport->add($newShop);

var_dump(Shops\Formatters\Shop::toArray($shop));
