<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;


// инициализируем транспорт для работы с сущностью Карты
$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
$card = $cardsTransport->addNewCard($newCard);

print('barcode: ' . $card->getBarcode() . PHP_EOL);

$cardFilter = new Cards\DTO\CardFilter();
$cardFilter->setBarcode($card->getBarcode());

print('card filter: ' . Cards\Formatters\CardFilter::toUrlArguments($cardFilter) . PHP_EOL);

$cardsCollection = $cardsTransport->getByFilter($cardFilter);
print ('cards found: ' . $cardsCollection->count() . PHP_EOL);

foreach ($cardsCollection as $card) {
    print(sprintf('%s | %s ' . PHP_EOL,
        $card->getCardId()->getId(),
        $card->getBarcode()
    ));
}