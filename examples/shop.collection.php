<?php
declare(strict_types=1);
require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Shops;

// инициализируем транспорт для работы с сущностью Магазины
$shopTransport = Shops\Transport\Fabric::getInstance($apiClient, $log);
$shops = $shopTransport->list();

foreach ($shops as $shop) {
    print_r(Shops\Formatters\Shop::toArray($shop));
}