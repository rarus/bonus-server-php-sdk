<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Shops;

// транзакция котора отражает прожажу, происходит списание бонусов

$transactionsTransport = Transactions\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
$card = $cardsTransport->addNewCard($newCard);
$card = $cardsTransport->activate($card);

print(sprintf('сard id: %s' . PHP_EOL, $card->getCardId()->getId()));
print(sprintf('сard code: %s' . PHP_EOL, $card->getCode()));

$newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
$shop = $shopTransport->add($newShop);
print(sprintf('shop id: %s' . PHP_EOL, $shop->getShopId()->getId()));
print(sprintf('shop name: %s' . PHP_EOL, $shop->getName()));

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

$authorName = 'Кассир Иванов Иван Иванович';
$description = 'Продажа по документу Чек№100500';
$document = Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0);
$refundDocument = Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0);
$cashRegister = \Rarus\BonusServer\Transactions\DTO\CashRegister\Fabric::createNewInstance((string)random_int(1000000, 100000000), 'касса 1');
$chequeNumber = (string)random_int(1000000, 100000000);

$saleTransaction = new Transactions\DTO\Sale();
$saleTransaction
    ->setCardId($card->getCardId())
    ->setShopId($shop->getShopId())
    ->setAuthorName($authorName)
    ->setDescription($description)
    ->setDocument($document)
    ->setCashRegister($cashRegister)
    ->setChequeNumber($chequeNumber)
    ->setBonusPayment(0)
    ->setChequeRows($chequeRowCollection);

// добавляем транзакцию
$finalScore = $transactionsTransport->addSaleTransaction($saleTransaction);
var_dump(Transactions\Formatters\FinalScore::toArray($finalScore));

// откатываем транзакцию
$refundTransaction = new Transactions\DTO\Refund();
$refundTransaction
    ->setCardId($card->getCardId())
    ->setShopId($shop->getShopId())
    ->setAuthorName($authorName)
    ->setDescription('отмена: ' . $description)
    ->setDocument($document)
    ->setRefundDocument($refundDocument)
    ->setRefundBonus(10)
    ->setCashRegister($cashRegister)
    ->setChequeNumber($chequeNumber)
    ->setChequeRows($chequeRowCollection);

$finalScore = $transactionsTransport->addRefundTransaction($refundTransaction);
var_dump(Transactions\Formatters\FinalScore::toArray($finalScore));
