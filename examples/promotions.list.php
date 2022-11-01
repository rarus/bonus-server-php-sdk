<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Notifications\DTO\NewNotification;
use Rarus\BonusServer\Notifications\DTO\NotificationId;
use Rarus\BonusServer\Notifications\DTO\NotificationOrganizationFilter;
use Rarus\BonusServer\Notifications\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Promotions\DTO\Promotion;
use Rarus\BonusServer\Promotions\DTO\PromotionFilter;
use Rarus\BonusServer\Promotions\DTO\PromotionId;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users;

$promotionsTransport = \Rarus\BonusServer\Promotions\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// Добавляем новое уведомление
$promotion = new Promotion(new PromotionId(
    sprintf('id-%d', \random_int(0, PHP_INT_MAX))
));
$promotion
    ->setName('test promotion')
    ->setShortDescription('short description')
    ->setFullDescription('full description');

$promotionsTransport->store($promotion);

// Получаем уведомления
$filter = new PromotionFilter();
$paginationResponse = $promotionsTransport->list($filter, new Pagination());

if ($paginationResponse->getPromotionCollection()->count()) {
    foreach ($paginationResponse->getPromotionCollection() as $promotion) {
        print_r(sprintf("promotion %s \n", $promotion->getPromotionId()->getId()));
        print_r(sprintf("name %s \n", $promotion->getName()));
        print_r(sprintf("text %s \n", $promotion->getShortDescription()));
    }

    print "pages:\n";
    print_r(sprintf("pageSize %s \n", $paginationResponse->getPagination()->getPageSize()));
    print_r(sprintf("pageNumber %s \n", $paginationResponse->getPagination()->getPageNumber()));
    print_r(sprintf("items %s \n", $paginationResponse->getPagination()->getResultPagesCount()));
    print_r(sprintf("pages %s \n", $paginationResponse->getPagination()->getResultPagesCount()));
}
