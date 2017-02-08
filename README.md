# rarus-bonus-server-php-sdk

Библиотека для работы с REST API продукта Бонусный сервер

## Установка

Установка последней версии через composer

```
$ composer require rarus/bonus-server-php-sd
```

## О продукте

### Требования

* php: >=5.5
* ext-json:*
* ext-curl:*
* psr/log: ^1.0
* guzzlehttp/guzzle: 6.*
* Monolog: 1.*

### Ошибки и вопросы

Задавать впросы, а также отправлять информацию об ошибках можно на [GitHub](https://github.com/rarus/bonus-server-php-sdk/issues) или на [почту](mailto:eran@rarus.ru)


### Лицензия

rarus-bonus-server-php-sdk лицензирована - подробнее в файле ```LICENSE.txt```

## Примеры

###Подключение под ролью организатора

```php
<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\MessageFormatter;

use Rarus\BonusServer\ApiClient;

$log = new Logger("bonus-server-log");
$log->pushHandler(new StreamHandler('debug.log'));

$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(
    \GuzzleHttp\Middleware::log(
        $log,
        new \GuzzleHttp\MessageFormatter(\GuzzleHttp\MessageFormatter::DEBUG)
    )
);

//данные для авторизации
$serverName = 'server.ru';
$orgLogin = 'AAAAA';
$orgPassw = 'BBBBB';

$httpClient = new \GuzzleHttp\Client();
$bsApiClient = new ApiClient($serverName, $httpClient, $log);
/**
 * @var \Rarus\BonusServer\Auth\Token $authToken
 */
//получить токен для роли организатор
$authToken = $bsApiClient->getAuthTokenForOrganizationRole($orgLogin, $orgPassw);
$bsApiClient->setAuthToken($authToken);
$bsApiClient->setGuzzleHandlerStack($guzzleHandlerStack);
?>
```

###Подключение под ролью клиента

```php
<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\MessageFormatter;

use Rarus\BonusServer\ApiClient;

$log = new Logger("bonus-server-log");
$log->pushHandler(new StreamHandler('debug.log'));

$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(
    \GuzzleHttp\Middleware::log(
        $log,
        new \GuzzleHttp\MessageFormatter(\GuzzleHttp\MessageFormatter::DEBUG)
    )
);

//данные для авторизации
$serverName = 'server.ru';
$clientLogin = 'AAAAA';
$clientPassw = 'BBBBB';
$clientcompanyId = 1;

$httpClient = new \GuzzleHttp\Client();
$bsApiClient = new ApiClient($serverName, $httpClient, $log);
/**
 * @var \Rarus\BonusServer\Auth\Token $authToken
 */
//получить токен для роли клиента
$authToken = $bsApiClient->getAuthTokenForClientRole($clientLogin, $clientPassw, $clientcompanyId);
$bsApiClient->setAuthToken($authToken);
$bsApiClient->setGuzzleHandlerStack($guzzleHandlerStack);
?>
```

###Добавить нового пользователя

```php
<?php
$obUserManager = new \Rarus\BonusServer\User\UserManager($bsApiClient);

$clientRole = 'client';
$clientName = 'AAAAA';
$clientLogin = 'BBBBB';
$clientPassw = 'CCCCC';
$clientEmail = 'AAAAA@BB.ru';
$clientPhone = '1111111';
$clientBirthday = 111111111;
$clienCompanyId = 11;

$arUser = array(
    "role" => $clientRole,
    "name" => $clientName,
    "login" => $clientLogin,
    "password" => sha1($clientPassw),
    "email" => $clientEmail,
    "phone" => $clientPhone,
    "birthdate" => $clientBirthday,
    "company_id" => $clienCompanyId
);

$infoAddUser = $obUserManager->Add($arUser);
?>
```


###Получить список карт клиента

```php
<?php
$obCardManager = new \Rarus\BonusServer\Card\CardManager($bsApiClient);
$apiResult = $obCardManager->getUserCardsList();
$obCardStorage = $apiResult->getResponseData();
foreach ($obCardStorage as $cnt => $cardItem) {
    print($cardItem->getBarCode().PHP_EOL);
    print($cardItem->getMagCode().PHP_EOL);
    print($cardItem->getName().PHP_EOL);
    print('============'.PHP_EOL.PHP_EOL);
}
?>
```

###Добавить новую карту пользователя

```php
<?php
$obCardManager = new \Rarus\BonusServer\Card\CardManager($bsApiClient);
$cardName = 'AAAAA';
$cardDescr = 'BBBBB';

$obCard = $obCardManager->Add($cardName,$cardDescr);
print($obCard->getName().PHP_EOL);
print($obCard->getBarCode().PHP_EOL);
print($obCard->getMagCode().PHP_EOL);
?>