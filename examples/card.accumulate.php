<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;

// инициализируем транспорт для работы с сущностью Магазины
$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// добавляем карту
$newCard = Cards\DTO\Fabric::createNewInstance(
    '12345987654321',
    (string)random_int(1000000, 100000000),
    new \Money\Currency('RUB'));
$card = $cardsTransport->addNewCard($newCard);
var_dump(Cards\Formatters\Card::toArray($card));

// активируем карту
$activeCard = $cardsTransport->activate($card);
var_dump(Cards\Formatters\Card::toArray($activeCard));

// устанавливаем на ней нужную сумму накоплений по транзакциям
$cardsTransport->setAccumulationAmount($activeCard, new \Money\Money('45000', new \Money\Currency('RUB')));
// перечитываем карту

$card = $cardsTransport->getByCardId($activeCard->getCardId());

var_dump(Cards\Formatters\Card::toArray($card));