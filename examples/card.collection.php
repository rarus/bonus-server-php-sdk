<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;


// инициализируем транспорт для работы с сущностью Магазины
$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// получаем список магазинов
$cardsWithPagination = $cardsTransport->list(new \Rarus\BonusServer\Transport\DTO\Pagination(10));
// показываем список магазинов
foreach ($cardsWithPagination->getCardCollection() as $card) {
    var_dump(\Rarus\BonusServer\Cards\Formatters\Card::toArray($card));
}