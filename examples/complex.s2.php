<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Users;
use Rarus\BonusServer\Shops;
use Rarus\BonusServer\Shops\DTO\ShopCollection;
use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Transactions\DTO\Points\Transactions\TransactionCollection;
use Rarus\BonusServer\Transactions\DTO\SalesHistory\HistoryItemCollection;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;

print('вывод истории операций в ЛК клиента' . PHP_EOL);

/**
 * 1. получение списка карт по пользователю
 * 2. получение транзакций по каждой карте
 * 3. получение истории покупок
 */

$orgCardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgShopsTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgTransactionsTransport = Transactions\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// готовим тестовые данные
//  - тестовые данные генерируются на стороне БС

// получили карту с демоданными
$card = $orgCardsTransport->getByCardId(new Cards\DTO\CardId('e0a84c5e-bf66-4100-98ba-858bb66c0ce5'));

// получили магазины организации
$shopCollection = $orgShopsTransport->list();

print('---------------' . PHP_EOL);
print(sprintf('получаем транзакции баллов по карте с id %s' . PHP_EOL, $card->getCardId()->getId()));


// получаем историю покупок по карте
// там содержится информация о покупках
$salesHistory = $orgTransactionsTransport->getSalesHistoryByCard($card);

//
// получение транзакций бонусных баллов по карте вообще всех
$transactionsWithPagination = $orgTransactionsTransport->getTransactionsByCard($card);
print(sprintf('получение всех транзакций по карте и их показ: %s шт.' . PHP_EOL, $transactionsWithPagination->getTransactionCollection()->count()));
showTransactionsList($transactionsWithPagination->getTransactionCollection(), $salesHistory, $shopCollection);


// получаем первые 10 транзакций
$transactionsWithPagination = $orgTransactionsTransport->getTransactionsByCard($card, null, null, new \Rarus\BonusServer\Transport\DTO\Pagination(10, 1));
print(sprintf('получение первых 10 транзакций по карте и их показ: %s шт.' . PHP_EOL, $transactionsWithPagination->getTransactionCollection()->count()));
showTransactionsList($transactionsWithPagination->getTransactionCollection(), $salesHistory, $shopCollection);

// получаем n транзакций по фильтру с датами
$dateFrom = DateTime::createFromFormat('Y.m.d H:i:s', '2018.09.05 09:14:00', new \DateTimeZone('UTC'));
$dateTo = DateTime::createFromFormat('Y.m.d H:i:s', '2018.09.05 09:20:00', new \DateTimeZone('UTC'));

$transactionsWithPagination = $orgTransactionsTransport->getTransactionsByCard($card, $dateFrom, $dateTo);
print(sprintf('получение транзакций по карте за период времени и их показ: %s шт.' . PHP_EOL, $transactionsWithPagination->getTransactionCollection()->count()));

showTransactionsList($transactionsWithPagination->getTransactionCollection(), $salesHistory, $shopCollection);

/**
 * @param TransactionCollection $transactionCollection
 * @param HistoryItemCollection $historyItemCollection
 * @param ShopCollection        $shopCollection
 */
function showTransactionsList(TransactionCollection $transactionCollection, HistoryItemCollection $historyItemCollection, ShopCollection $shopCollection): void
{
    print('                GUID                 |         timestamp        |  тип  |баллы в копейках| баллы будут доступны до | Id магазина | документ покупки | стоимость ' . PHP_EOL);
    foreach ($transactionCollection as $trx) {
        print(sprintf(
            '%s | %s | %s |    %s    | %s | %s | %s | %s ' . PHP_EOL,
            $trx->getRowNumber(),
            $trx->getTime()->format(\DATE_ATOM),
            $trx->getType()->getCode(),
            $trx->getSum()->getAmount(),
            $trx->getInvalidatePeriod()->format(\DATE_ATOM),
            findShopAndGetName($shopCollection, $trx->getShopId()),
            $trx->getDocumentId()->getId(),
            findItemInSalesHistoryAndGetSumAsString($historyItemCollection, $trx->getDocumentId())
        ));
    }
}

/**
 * @param HistoryItemCollection $historyItemCollection
 * @param DocumentId            $documentId
 *
 * @return string
 */
function findItemInSalesHistoryAndGetSumAsString(Transactions\DTO\SalesHistory\HistoryItemCollection $historyItemCollection, DocumentId $documentId): string
{
    $sum = 'n/a';
    foreach ($historyItemCollection as $historyItem) {
        if ($historyItem->getDocumentId()->getId() === $documentId->getId()) {
            return $historyItem->getSum()->getAmount();
        }
    }

    return $sum;
}

/**
 * @param ShopCollection        $shopCollection
 * @param null|Shops\DTO\ShopId $shopId
 *
 * @return string
 */
function findShopAndGetName(Shops\DTO\ShopCollection $shopCollection, Shops\DTO\ShopId $shopId): string
{
    if ($shopId === null || $shopId->getId() === '') {
        return 'n/a';
    }

    foreach ($shopCollection as $shopItem) {
        if ($shopItem->getShopId()->getId() === $shopId->getId()) {
            return $shopItem->getName();
        }
    }
}
