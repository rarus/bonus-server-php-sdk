<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Segments;
use Rarus\BonusServer\Transport\DTO\Pagination;

// инициализируем транспорт для работы с сущностью Магазины
$segmentTransport = Segments\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newSegment = (new Segments\DTO\Segment())->setName('Детские товары')->setMaxPaymentPercent(20);

// добавляем сегмент
$segment = $segmentTransport->addNewSegment($newSegment);

print(sprintf(
    'добавлен сегмент [%s] c id [%s]' . PHP_EOL,
    $segment->getName(),
    $segment->getSegmentId()->getId()
));

print_r(Segments\Formatters\Segment::toArray($segment));

// удаляем сегмент
$segmentTransport->delete($segment);

print(sprintf(
    'сегмент с id [%s] удалён' . PHP_EOL,
    $segment->getSegmentId()->getId()
)
);
