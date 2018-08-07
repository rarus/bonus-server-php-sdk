<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Transactions;

print('запрос баланса и оборота' . PHP_EOL);

// готовим тестовые данные

// получение выписки с карты
$orgCardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$card = $orgCardsTransport->getByCardId(new Cards\DTO\CardId('d894efc8-664c-41c5-9290-24a92c3756ba'));
print('запрос баланса без истории транзакций' . PHP_EOL);
$accountStatement = $orgCardsTransport->getAccountStatement($card, 5);

print(sprintf(
    'Баланс:' . PHP_EOL .
    '-всего: %s %s' . PHP_EOL .
    '-доступно: %s %s' . PHP_EOL
    ,
    $accountStatement->getBalance()->getTotal()->getAmount(),
    $accountStatement->getBalance()->getTotal()->getCurrency()->getCode(),
    $accountStatement->getBalance()->getAvailable()->getAmount(),
    $accountStatement->getBalance()->getAvailable()->getCurrency()->getCode())
);

print(sprintf('баллы, количество: %s' . PHP_EOL, $accountStatement->getPoints()->count()));
foreach ($accountStatement->getPoints() as $cnt => $point) {
    print(sprintf('%s|date create: %s | %s %s | active from %s to %s ' . PHP_EOL,
        $cnt,
        $point->getDateCreate()->format(\DATE_ATOM),
        $point->getSum()->getAmount(),
        $point->getSum()->getCurrency()->getCode(),
        $point->getActiveFrom() === null ? 'n/a' : $point->getActiveFrom()->format(\DATE_ATOM),
        $point->getActiveTo() === null ? 'n/a' : $point->getActiveTo()->format(\DATE_ATOM)
    ));
}

print(sprintf('транзакции, количество: %s' . PHP_EOL, $accountStatement->getTransactions()->count()));
foreach ($accountStatement->getTransactions() as $cnt => $trx) {
    print(sprintf('%s|date create: %s | %s %s ' . PHP_EOL,
        $cnt,
        $trx->getDate()->format(\DATE_ATOM),
        $trx->getTransactionSum()->getAmount(),
        $trx->getTransactionSum()->getCurrency()->getCode()
    ));
}