<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;

print('вывод истории операций в ЛК клиента' . PHP_EOL);

/**
 * 1. получение списка карт по пользователю
 * 2. получение транзакций по каждой карте
 * 3. получение истории покупок
 */

$orgCardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$orgUsersTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// готовим тестовые данные

// получаем тестовые данные
// получили пользователя
$user = $orgUsersTransport->getByUserId(new Users\DTO\UserId('35518a45-2fca-49bb-88c3-f697fbf7b036'));
var_dump($user->getName());
var_dump($user->getEmail());

// получили список карт по пользователю
$cards = $orgCardsTransport->getByUser($user);

var_dump($cards->count());