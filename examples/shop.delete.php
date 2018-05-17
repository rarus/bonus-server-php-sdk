<?php
declare(strict_types=1);
require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Shops;
use Rarus\BonusServer\Responses;

// инициализируем транспорт для работы с сущностью Магазины
$shopTransport = Shops\Transport\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newShop = Rarus\BonusServer\Shops\DTO\Fabric::createNewInstance('Новый магазин для удаления333');

// добавляем магазин
$shop = $shopTransport->add($newShop);
print(sprintf('добавлен магазин [%s] c id [%s]' . PHP_EOL,
    $shop->getName(),
    $shop->getId()
));

print_r(Shops\Formatters\Shop::toArray($shop));
// удаляем магазин
$deletedShop = $shopTransport->delete($shop);

print(sprintf('магазин с id [%s] удалён' . PHP_EOL,
    $shop->getId())
);