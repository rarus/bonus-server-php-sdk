<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';
date_default_timezone_set('UTC');

if (! class_exists(Dotenv::class)) {
    throw new LogicException('You need to add "symfony/dotenv" as Composer dependencies.');
}

(new Dotenv)->loadEnv(dirname(__DIR__).'/tests/.env');

// фабрика для ApiClient с параметрами подключения к тестовому серверу
require __DIR__.'/TestEnvironmentManager.php';
