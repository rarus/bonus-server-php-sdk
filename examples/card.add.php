<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;


// инициализируем транспорт для работы с сущностью Магазины
$cardsTransport = Cards\Transport\Fabric::getInstance($apiClient, $log);

$newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000));

$card = $cardsTransport->addNewCard($newCard);

var_dump(Cards\Formatters\Card::toArray($card));