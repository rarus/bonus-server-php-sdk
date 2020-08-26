<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\UidProcessor;
use Rarus\BonusServer;

$log = new Logger('rarus-bonus-service');

$log->pushProcessor(new MemoryUsageProcessor());
$log->pushProcessor(new MemoryUsageProcessor());
$log->pushProcessor(new MemoryPeakUsageProcessor());
$log->pushProcessor(new IntrospectionProcessor());
$log->pushProcessor(new UidProcessor());


$log->pushHandler(new \Monolog\Handler\StreamHandler('rarus-bonus-service.log', Logger::DEBUG));

$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(
    Middleware::log(
        $log,
        new MessageFormatter(MessageFormatter::SHORT)
    )
);

// http-клиент
$httpClient = new \GuzzleHttp\Client();
$log->info('=================================================================');
$log->info('rarus.bonus.server.apiClient.start');


// параметры подключения ожидаем как аргументы командной строки
$argv = getopt('', ['url::', 'login::', 'password::', 'role::']);
$example = 'php -f shop.collection.php -- --url=https://127.0.0.1 --login=root --password=123456 --role=organization';
if ($argv['url'] === null) {
    $errMsg = sprintf('ошибка: не найден url для подключения, пример вызова скрипта: %s', $example);
    $log->error($errMsg, [$argv]);
    print($errMsg . PHP_EOL);
    exit();
}
if ($argv['login'] === null) {
    $errMsg = sprintf('ошибка: не найден логин для подключения, пример вызова скрипта: %s', $example);
    $log->error($errMsg, [$argv]);
    print($errMsg . PHP_EOL);
    exit();
}
if ($argv['password'] === null) {
    $errMsg = sprintf('ошибка: не найден пароль для подключения, пример вызова скрипта: %s', $example);
    $log->error($errMsg, [$argv]);
    print($errMsg . PHP_EOL);
    exit();
}
if ($argv['role'] === null) {
    $errMsg = sprintf('ошибка: не найдена роль для подключения, пример вызова скрипта: %s', $example);
    $log->error($errMsg, [$argv]);
    print($errMsg . PHP_EOL);
    exit();
}

// конструируем объект для авторизации
switch (strtolower($argv['role'])) {
    case 'client':
        $credentials = Rarus\BonusServer\Auth\Fabric::createCredentialsForRoleClient($argv['login'], $argv['password']);
        break;
    case 'organization':
        $credentials = Rarus\BonusServer\Auth\Fabric::createCredentialsForRoleOrganization($argv['login'], $argv['password']);
        break;
    default:
        $errMsg = sprintf('ошибка: неизвестная роль для подключения, пример вызова скрипта: %s', $example);
        $log->error($errMsg, [$argv]);
        print($errMsg . PHP_EOL);
        exit();
}

// получаем API-клиент для работы с бонусным сервером
try {
    $apiClient = new BonusServer\ApiClient($argv['url'], new \GuzzleHttp\Client(), $log);
    $apiClient->setGuzzleHandlerStack($guzzleHandlerStack);
    $newAuthToken = $apiClient->getNewAuthToken($credentials);
    $apiClient->setAuthToken($newAuthToken);
} catch (BonusServer\Exceptions\BonusServerException $bonusServerException) {
    // ловим все исключения предметной области
    var_dump('Исключение предметной области: ');
    var_dump(get_class($bonusServerException));
    var_dump($bonusServerException->getMessage());
    var_dump($bonusServerException->getCode());
    var_dump($bonusServerException->getTraceAsString());
    exit();
} catch (\Throwable $otherExceptions) {
    var_dump('Все остальные исключения: ');
    var_dump(get_class($otherExceptions));
    var_dump($otherExceptions->getMessage());
    var_dump($otherExceptions->getCode());
    var_dump($otherExceptions->getTraceAsString());
    exit();
}
