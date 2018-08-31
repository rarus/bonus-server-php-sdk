<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Transactions;

print('вывод истории операций в ЛК клиента' . PHP_EOL);

/**
 * 1. получение списка карт по пользователю
 * 2. получение транзакций по каждой карте
 * 3. получение истории покупок
 */

$orgCardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgUsersTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgTransactionsTransport = Transactions\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

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
$card = $orgCardsTransport->addNewCard($newCard, new \Money\Money(5000000000, new \Money\Currency('RUB')));
$updatedCard = $orgCardsTransport->attachToUser($card, $user);

$activatedCard = $orgCardsTransport->activate($card);

// получаем тестовые данные
// получили пользователя
$user = $orgUsersTransport->getByUserId($user->getUserId());
var_dump($user->getName());
var_dump($user->getEmail());

// получили список карт по пользователю
$cards = $orgCardsTransport->getByUser($user);
print(sprintf('количество карт: %s' . PHP_EOL, $cards->count()));

foreach ($cards as $card) {
    print('---------------' . PHP_EOL);
    print(sprintf('получаем транзакции баллов по карте с id %s' . PHP_EOL, $card->getCardId()->getId()));
    // получение транзакций бонусных баллов по карте
    $transactionCollection = $orgTransactionsTransport->getTransactionsByCard($card);
    foreach ($transactionCollection as $trx) {
        print(sprintf('-- %s | %s %s | %s' . PHP_EOL,
            $trx->getPointId()->getId(),
            $trx->getSum()->getAmount(),
            $trx->getSum()->getCurrency()->getCode(),
            $trx->getType()->getCode())
        );
    }
    // получение истории покупок по карте
    $salesHistory = $orgTransactionsTransport->getSalesHistoryByCard($card);
    print(sprintf('история покупок: ' . PHP_EOL));
    foreach ($salesHistory as $historyItem) {
        print(sprintf('%s | %s | %s %s' . PHP_EOL,
            $historyItem->getLineNumber(),
            $historyItem->getDocumentId()->getId(),
            $historyItem->getSum()->getAmount(),
            $historyItem->getSum()->getCurrency()->getCode()
        ));
        print('====== табличная часть: ' . PHP_EOL);
        foreach ($historyItem->getProducts() as $productRow) {
            print(sprintf('            %s | %s |  %s cnt | %s %s ' . PHP_EOL,
                $productRow->getArticleId()->getId(),
                $productRow->getName(),
                $productRow->getQuantity(),
                $productRow->getPrice()->getAmount(),
                $productRow->getPrice()->getCurrency()
            ));
        }
    }
}