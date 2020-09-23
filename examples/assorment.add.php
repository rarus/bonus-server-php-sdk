<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Articles;

// инициализируем транспорт для работы с сущностью Магазины
$articleTransport = Articles\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$articleId = new Articles\DTO\ArticleId('id-' . random_int(0, PHP_INT_MAX));
$newArticle = new Articles\DTO\Article($articleId, 'Test good');
$newArticleCollection = new Articles\DTO\ArticleCollection();
$newArticleCollection->attach($newArticle);

var_dump(Articles\Formatters\Article::toArray($newArticle));

try {
    $articleTransport->store($newArticleCollection);
    $article = $articleTransport->getByArticleId($articleId);
    var_dump(Articles\Formatters\Article::toArray($article));

} catch (\Rarus\BonusServer\Exceptions\NetworkException $e) {
} catch (\Rarus\BonusServer\Exceptions\ApiClientException $e) {
} catch (\Rarus\BonusServer\Exceptions\UnknownException $e) {
}


