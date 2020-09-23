<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Articles;
use Rarus\BonusServer\Transport\DTO\Pagination;

// инициализируем транспорт для работы с сущностью Магазины
$articleTransport = Articles\Transport\Role\Organization\Fabric::getInstance(
    $apiClient,
    new \Money\Currency('RUB'),
    $log
);

$articleFilter = new Articles\DTO\ArticleFilter();
$articles = $articleTransport->list($articleFilter, new Pagination());

// показываем список товаров
foreach ($articles->getArticleCollection() as $article) {
    print(sprintf(
        '%s | %s ' . PHP_EOL,
        $article->getArticleId()->getId(),
        $article->getName()
    )
    );
}

printf('page: %s' . PHP_EOL, $articles->getPagination()->getPageNumber());
