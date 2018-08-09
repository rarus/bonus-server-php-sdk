<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Shops;

print('запрос баланса и оборота' . PHP_EOL);

// готовим тестовые данные
// получение выписки с карты
$orgCardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
// инициализируем транспорт для работы с сущностью Магазины
$orgShopTransport = Shops\Transport\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$shop = $orgShopTransport->getById(new Shops\DTO\ShopId('e776a0fb-7889-480f-b11b-ce3270bc46f5'));
$card = $orgCardsTransport->getByBarcode(new Cards\DTO\Barcode\Barcode('0000000000017'));

$paymentBalance = $orgCardsTransport->getPaymentBalance($shop->getShopId(), $card);

print('доступный баланс: ' . PHP_EOL);
print(sprintf('карта: ' . PHP_EOL .
    '- available balance %s %s' . PHP_EOL .
    '- max payment balance %s %s' . PHP_EOL .
    '- card level id %s' . PHP_EOL,

    $paymentBalance->getAvailableBalance()->getAmount(),
    $paymentBalance->getAvailableBalance()->getCurrency()->getCode(),
    $paymentBalance->getPaymentBalance()->getAmount(),
    $paymentBalance->getPaymentBalance()->getCurrency()->getCode(),
    $paymentBalance->getCardLevelId()->getId()
));