<?php

use \Rarus\BonusServer\Auth\Transport;

require_once __DIR__ . '/init.php';

// пример получения авторизационного токена для роли «Организация»
$authTransport = new Transport($bsApiClient, $log);
$authToken = $authTransport->getAuthTokenForClientRole($argv['login'], $argv['password']);

var_dump($authToken->toArray());