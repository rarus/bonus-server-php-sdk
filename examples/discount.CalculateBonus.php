<?php
declare(strict_types=1);
require_once __DIR__ . '/init.php';
require_once '../tests/DemoDataGenerator.php';

use Rarus\BonusServer\Discounts;
use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Shops;

$discountsTransport = Discounts\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
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


// табличная часть транзакции
$discountDocument = new Discounts\DTO\Document();
$discountDocument
    ->setShopId($shop->getShopId())
    ->setCard($card)
    ->setChequeRows(DemoDataGenerator::createChequeRows(random_int(1, 20), new \Money\Currency('RUB')));

print('документ для предрасчёта скидок и скидочных бонусов:' . PHP_EOL);
$estimate = $discountsTransport->calculateDiscountsAndBonusDiscounts($discountDocument);
if (null === $estimate) {
    print ('скидок и бонусов нет, создайте их в 1С' . PHP_EOL);
    exit();
}

print('результаты предрасчёта:' . PHP_EOL);
print('Строки документа:' . PHP_EOL);
foreach ($estimate->getDocumentItems() as $documentItem) {
    print(sprintf('%s | %s | %s шт. | с ценой %s копеек в валюте %s | итого: %s | процент скидки %s на сумму %s' . PHP_EOL,
        $documentItem->getLineNumber(),
        $documentItem->getArticleId()->getId(),
        $documentItem->getQuantity(),
        $documentItem->getPrice()->getAmount(),
        $documentItem->getPrice()->getCurrency()->getCode(),
        $documentItem->getSum()->getAmount(),
        $documentItem->getBonus()->getPercent(),
        $documentItem->getBonus()->getSum()->getAmount()
    ));
}
print('Скидки:' . PHP_EOL);
foreach ($estimate->getDiscountItems() as $discountItem) {
    print(sprintf('%s |скидка %s с id %s | тип %s|значение %s| подарки из сегмента - %s|' . PHP_EOL,
        $discountItem->getLineNumber(),
        $discountItem->getName(),
        $discountItem->getDiscountId()->getId(),
        $discountItem->getTypeId(),
        $discountItem->getValue(),
        $discountItem->getGiftSegment() === null ? 'нет подарков ' : $discountItem->getGiftSegment()->getId()

    ));
}