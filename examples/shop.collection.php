<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Shops;

// инициализируем транспорт для работы с сущностью Магазины
$shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// получаем список магазинов
$shops = $shopTransport->list();
// показываем список магазинов
foreach ($shops as $shop) {
    print(sprintf(
        '%s | %s ' . PHP_EOL,
        $shop->getShopId()->getId(),
        $shop->getName()
    )
    );
}
