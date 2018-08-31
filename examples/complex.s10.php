<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Shops;
use \Rarus\BonusServer\Transactions;

print('запрос баланса и оборота' . PHP_EOL);

$orgCardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgUsersTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgTransactionsTransport = Transactions\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgShopTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// готовим тестовые данные
$newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
    'grishi-' . random_int(0, PHP_INT_MAX),
    'Михаил Гришин',
    '+7978 888 22 22',
    'grishi@rarus.ru',
    null,
    new \DateTime('06.06.1985')
);
$user = $orgUsersTransport->addNewUser($newUser);

$cardLevels = $orgCardsTransport->getCardLevelList();
$newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
$newCard->setCardLevelId($cardLevels->getFirstLevel()->getLevelId());
$card = $orgCardsTransport->addNewCard($newCard, new \Money\Money(1000, new \Money\Currency('RUB')));
$updatedCard = $orgCardsTransport->attachToUser($card, $user);

$activatedCard = $orgCardsTransport->activate($card);

$newShop = Rarus\BonusServer\Shops\DTO\Fabric::createNewInstance('Новый магазин');
$shop = $orgShopTransport->add($newShop);


// пример работы
$shop = $orgShopTransport->getById($shop->getShopId());
$card = $orgCardsTransport->getByBarcode($card->getBarcode());

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