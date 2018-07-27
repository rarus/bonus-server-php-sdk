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

// получаем тестовые данные
// получили пользователя
$user = $orgUsersTransport->getByUserId(new Users\DTO\UserId('35518a45-2fca-49bb-88c3-f697fbf7b036'));
var_dump($user->getName());
var_dump($user->getEmail());

// получили список карт по пользователю
$cards = $orgCardsTransport->getByUser($user);
print(sprintf('количество карт: %s' . PHP_EOL, $cards->count()));

foreach ($cards as $card) {
    print('---------------' . PHP_EOL);
    print(sprintf('получаем транзакции по карте с id %s' . PHP_EOL, $card->getCardId()->getId()));
    // получение транзакций по карте
    $transactionCollection = $orgTransactionsTransport->getTransactionsByCard($card);
    foreach ($transactionCollection as $trx) {
        print(sprintf('-- %s | %s %s | %s' . PHP_EOL,
            $trx->getPointId()->getId(),
            $trx->getSum()->getAmount(),
            $trx->getSum()->getCurrency()->getCode(),
            $trx->getType()->getCode())
        );
    }
}