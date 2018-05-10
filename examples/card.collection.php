<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;


// инициализируем транспорт для работы с сущностью Магазины
$cardsTransport = Cards\Transport\Fabric::getInstance($apiClient, $log);

// получаем список магазинов
$cards = $cardsTransport->list();
// показываем список магазинов
foreach ($cards as $card) {
    var_dump(\Rarus\BonusServer\Cards\Formatters\Card::toArray($card));
}