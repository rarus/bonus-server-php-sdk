<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';
require_once '..' . '/tests/DemoDataGenerator.php';

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Shops;
use Rarus\BonusServer\Discounts;
use \Rarus\BonusServer\Shops\DTO\ShopCollection;
use \Rarus\BonusServer\Transactions;
use \Rarus\BonusServer\Transactions\DTO\Points\Transactions\TransactionCollection;
use \Rarus\BonusServer\Transactions\DTO\SalesHistory\HistoryItemCollection;
use \Rarus\BonusServer\Transactions\DTO\Document\DocumentId;

print('рассчёт бонусов на указанную дату' . PHP_EOL);

/**
 * 1. Вход в личный кабинет пользователя ()
 * 2. Получение списка карт пользователя
 * 3. Для каждой из них выполняем предрасчет organization/calculate.
 * 4. Чтобы баллы начислялись на товар, который был заказан, а на момент оплаты скидка уже не действует - в organization/process_bonus необходимо передать дату.
 *  на которую необходимо произвести расчет скидок ("date_calculate")
 */
$orgCardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgShopsTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgTransactionsTransport = Transactions\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgDiscountsTransport = Discounts\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// готовим тестовые данные
//  - тестовые данные генерируются на стороне БС

// получили магазины организации
$shopCollection = $orgShopsTransport->list();
// берём любой
$shop = $shopCollection->current();
// получили карту с демоданными
$card = $orgCardsTransport->getByCardId(new Cards\DTO\CardId('e0a84c5e-bf66-4100-98ba-858bb66c0ce5'));

// табличная часть транзакции
$chequeRowCollection = new Transactions\DTO\ChequeRows\ChequeRowCollection();;
$chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
    ->setLineNumber(1)
    ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-11111'))
    ->setName('товар 1')
    ->setQuantity(2)
    ->setPrice(new Money\Money(400, new \Money\Currency('RUB')))
    ->setSum(new Money\Money(4000, new \Money\Currency('RUB')))
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
    ->setBonusPayment(20)
    ->setChequeRows($chequeRowCollection);

$dateCalculate = new \DateTime('now');
print(sprintf('текущая дата: %s' . PHP_EOL, $dateCalculate->format(\DATE_ATOM)));
$dateCalculate->sub(new \DateInterval('P2D'));

print(sprintf('дата, на которую считаем бонусы: %s' . PHP_EOL, $dateCalculate->format(\DATE_ATOM)));

$result = $orgTransactionsTransport->addSaleTransaction($saleTransaction, $dateCalculate);