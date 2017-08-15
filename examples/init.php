<?php
require_once '..' . '/vendor/autoload.php';

use \Monolog\Logger;
use \Monolog\Processor\MemoryUsageProcessor;
use \Monolog\Processor\UidProcessor;
use \Monolog\Processor\MemoryPeakUsageProcessor;
use \Monolog\Processor\IntrospectionProcessor;
use \Monolog\Handler\StreamHandler;


//use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\Middleware;
use \GuzzleHttp\MessageFormatter;

use Rarus\BonusServer;
use Rarus\BonusServer\ApiClient;

// инициализируем логи
$log = new Logger('rarus-kkt-php-sdk');

$log->pushProcessor(new MemoryUsageProcessor());
$log->pushProcessor(new MemoryPeakUsageProcessor);
$log->pushProcessor(new IntrospectionProcessor);
$log->pushProcessor(new UidProcessor());
$log->pushHandler(new StreamHandler('rarus-bonus-server.log', Logger::DEBUG));

// http-клиент
$httpClient = new \GuzzleHttp\Client();
$log->info('=================================================================');

// параметры подключения ожидаем как аргументы командной строки
$argv = getopt('', ['url::', 'login::', 'password::']);

$example = 'php -f 01_menu.php -- --url=demo.rarus-online.com --login=123456 --password=789';

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

$httpClient = new \GuzzleHttp\Client();
$bsApiClient = new ApiClient($argv['url'], $httpClient, $log);