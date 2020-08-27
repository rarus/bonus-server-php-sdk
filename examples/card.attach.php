<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;

$newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
    'grishi-' . random_int(0, PHP_INT_MAX),
    'Михаил Гришин',
    '+7978 888 22 22',
    'grishi@rarus.ru'
);

$transport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$user = $transport->addNewUser($newUser);

print(sprintf('new user with id: %s' . PHP_EOL, $user->getUserId()->getId()));

// инициализируем транспорт для работы с сущностью Магазины
$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));

$card = $cardsTransport->addNewCard($newCard);

print(sprintf('new card with id: %s' . PHP_EOL, $card->getCardId()->getId()));

print('attach card to user...' . PHP_EOL);

$updatedCard = $cardsTransport->attachToUser($card, $user);

var_dump(Cards\Formatters\Card::toArray($updatedCard));
var_dump($updatedCard->getUserId()->getId());
var_dump($user->getUserId()->getId());
