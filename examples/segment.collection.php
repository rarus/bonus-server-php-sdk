<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Segments;
use Rarus\BonusServer\Transport\DTO\Pagination;

// инициализируем транспорт для работы с сущностью Магазины
$segmentTransport = Segments\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newSegment = (new Segments\DTO\Segment())->setName('Детские товары')->setMaxPaymentPercent(20);
$segment = $segmentTransport->addNewSegment($newSegment);

// получаем список сегментов
$segments = $segmentTransport->list(new Pagination());

// показываем список сегментов
foreach ($segments->getSegmentCollection() as $segment) {
    print(sprintf(
        '%s | %s ' . PHP_EOL,
        $segment->getSegmentId()->getId(),
        $segment->getName()
    )
    );
}
