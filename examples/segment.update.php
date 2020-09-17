<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Segments;

// инициализируем транспорт для работы с сущностью Магазины
$segmentTransport = Segments\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$newSegment = (new Segments\DTO\Segment())->setName('Детские товары')->setMaxPaymentPercent(20);

var_dump(Segments\Formatters\Segment::toArray($newSegment));

$segment = $segmentTransport->addNewSegment($newSegment);
$segment->setName('Поменяли название сегмента');
$updatedSegment = $segmentTransport->update($segment);

var_dump(Segments\Formatters\Segment::toArray($updatedSegment));
