<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Shops;
use Rarus\BonusServer\Users;
use Rarus\BonusServer\Auth;

// транзакция котора отражает прожажу, происходит списание бонусов
$companyId = $apiClient->getAuthToken()->getCompanyId();

$cardsOrganizationRoleTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$userOrganizationTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$transactionsTransport = Transactions\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
$card = $cardsOrganizationRoleTransport->addNewCard($newCard);
$cardWithoutUser = $cardsOrganizationRoleTransport->activate($card);

print(sprintf('сard id: %s' . PHP_EOL, $cardWithoutUser->getCardId()->getId()));
print(sprintf('сard code: %s' . PHP_EOL, $cardWithoutUser->getCode()));

$newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
$shop = $shopTransport->add($newShop);
print(sprintf('shop id: %s' . PHP_EOL, $shop->getShopId()->getId()));
print(sprintf('shop name: %s' . PHP_EOL, $shop->getName()));

// добавляем пользователя
$userPassword = sha1('12345');
$userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);
$newUsersCollection = new Users\DTO\UserCollection();
$newUsersCollection->attach(
    Users\DTO\Fabric::createNewInstance(
        $userUid,
        'Михаил Гришин (импорт)',
        '+7978 888 22 22',
        'grishi@rarus.ru',
        null,
        null,
        $userPassword,
        new Users\DTO\UserId($userUid),
        Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )
);
$userOrganizationTransport->importNewUsers($newUsersCollection);

// привязываем карту к пользователю
$importedUser = $userOrganizationTransport->getByUserId(new Users\DTO\UserId($userUid));
$card = $cardsOrganizationRoleTransport->attachToUser($cardWithoutUser, $importedUser);
print(sprintf('attach card with id [%s] to user with id [%s]' . PHP_EOL, $card->getCardId()->getId(), $importedUser->getUserId()->getId()));
print(sprintf('сard id: %s' . PHP_EOL, $card->getCardId()->getId()));
print(sprintf('сard user id: %s' . PHP_EOL, $card->getUserId() !== null ? $card->getUserId()->getId() : null));

// конструируем транзакцию

// табличная часть транзакции
$chequeRowCollection = new Transactions\DTO\ChequeRows\ChequeRowCollection();

$chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
    ->setLineNumber(1)
    ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-11111'))
    ->setName('товар 1')
    ->setQuantity(2)
    ->setPrice(new Money\Money(400, new \Money\Currency('RUB')))
    ->setSum(new Money\Money(4000, new \Money\Currency('RUB')))
    ->setDiscount(new Money\Money(40, new \Money\Currency('RUB'))));
$chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
    ->setLineNumber(1)
    ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-222222'))
    ->setName('товар 1')
    ->setQuantity(2)
    ->setPrice(new Money\Money(900, new \Money\Currency('RUB')))
    ->setSum(new Money\Money(9000, new \Money\Currency('RUB')))
    ->setDiscount(new Money\Money(40, new \Money\Currency('RUB'))));

$saleTransaction = new Transactions\DTO\Sale();
$saleTransaction
    ->setCardId($card->getCardId())
    ->setShopId($shop->getShopId())
    ->setAuthorName('Кассир Иванов')
    ->setDescription('Продажа по документу Чек№100500')
    ->setDocument(Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0))
    ->setCashRegister(\Rarus\BonusServer\Transactions\DTO\CashRegister\Fabric::createNewInstance((string)random_int(1000000, 100000000), 'касса 1'))
    ->setChequeNumber((string)random_int(1000000, 100000000))
    ->setBonusPayment(0)
    ->setChequeRows($chequeRowCollection);

$finalScore = $transactionsTransport->addSaleTransaction($saleTransaction);
var_dump(Transactions\Formatters\FinalScore::toArray($finalScore));

$saleTransaction = new Transactions\DTO\Sale();
$chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
    ->setLineNumber(1)
    ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-222222'))
    ->setName('товар 1')
    ->setQuantity(2)
    ->setPrice(new Money\Money(100, new \Money\Currency('RUB')))
    ->setSum(new Money\Money(1000, new \Money\Currency('RUB')))
    ->setDiscount(new Money\Money(40, new \Money\Currency('RUB'))));
$saleTransaction
    ->setCardId($card->getCardId())
    ->setShopId($shop->getShopId())
    ->setAuthorName('Кассир Иванов')
    ->setDescription('Продажа по документу Чек№100501')
    ->setDocument(Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0))
    ->setCashRegister(\Rarus\BonusServer\Transactions\DTO\CashRegister\Fabric::createNewInstance((string)random_int(1000000, 100000000), 'касса 1'))
    ->setChequeNumber((string)random_int(1000000, 100000000))
    ->setBonusPayment(0)
    ->setChequeRows($chequeRowCollection);

$finalScore = $transactionsTransport->addSaleTransaction($saleTransaction);
var_dump(Transactions\Formatters\FinalScore::toArray($finalScore));
print('провели две транзакции по карте, получаем их из истории' . PHP_EOL);

// авторизуемся на бонусном сервере под учётной записью пользователя
$userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPassword);
$userAuthToken = $apiClient->getNewAuthToken($userCredentials);
$apiClient->setAuthToken($userAuthToken);

$cardsUserRoleTransport = Cards\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$transactionsRoleUser = Transactions\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$cards = $cardsUserRoleTransport->list();
print('cards list from user:' . PHP_EOL);
foreach ($cards as $card) {
    print(sprintf('card [%s]' . PHP_EOL, $card->getCardId()->getId()));
    print('--- transactions' . PHP_EOL);
    $history = $transactionsRoleUser->getSalesHistory($card);
    foreach ($history as $item) {
        print(sprintf(
            'trx id [%s] with sum [%s] on shop name [%s]' . PHP_EOL,
            $item->getId(),
            $item->getChequeSum()->getAmount(),
            $item->getShopName()
        ));
    }
}
