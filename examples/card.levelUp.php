<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;

$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$cardLevels = $cardsTransport->getCardLevelList();
$newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
$newCard->setCardLevelId($cardLevels->getFirstLevel()->getLevelId());
$card = $cardsTransport->addNewCard($newCard, new \Money\Money(5000000000, new \Money\Currency('RUB')));
$activatedCard = $cardsTransport->activate($card);

$result = $cardsTransport->levelUp($activatedCard);

var_dump($result);
