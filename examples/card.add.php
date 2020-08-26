<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;

// инициализируем транспорт для работы с сущностью Магазины
$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));

$card = $cardsTransport->addNewCard($newCard);

var_dump(Cards\Formatters\Card::toArray($card));
