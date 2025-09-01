# rarus-bonus-php-sdk

## Установка

```bash
composer require rarus/bonus-server-php-sdk^2.0
```

### Зависимости

- PHP \>= [8.2+](https://www.php.net/releases/)
- ext-json
- ext-curl

## Быстрый старт

```php
$client = RarusLMS::client('API_URL','API_TOKEN');

$card = $client->cards()->getById(1); // Возвращает Cards\DTO\CardDto
$user = $client->users()->getById(1); // Возвращает Users\DTO\UserDto

// Сериализация в массив (для логирования/кэша)
$payload = $card->toArray();
```

## Расширенный пример использования

```php
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Money\Currency;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Rarus\LMS\SDK\RarusLMS;
use Rarus\LMS\SDK\Users\DTO\Fabric;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

$logger = new Logger('rarus-bonus-service');
$logger->pushHandler(
    new StreamHandler(
        getenv('LOG_FILE'), 
        getenv('LOG_LEVEL'), 
    )
);

$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(
    Middleware::log(
        $logger,
        new MessageFormatter(MessageFormatter::DEBUG)
    )
);

$httpClient = new GuzzleHttp\Client([
    'base_uri' => getenv('API_URL'),
    'connect_timeout' => 10,
    'headers' => [
        'Accept' => 'application/json',
    ],
    'handler' => $guzzleHandlerStack,  
]);

$psr6Cache = new FilesystemAdapter(); 
$psr16Cache = new Psr16Cache($psr6Cache);

$client = RarusLMS::factory()
    ->setApiKey(getenv('API_TOKEN'))
    ->setHttpClient($httpClient)
    ->setLogger($logger)
    ->setCurrency(new Currency('RUB'))
    ->setDateTimeZone(new DateTimeZone('Europe/Moscow'))
    ->setCache($psr16Cache)
    ->build();

$userDto = Fabric::createNewInstance(
    name: 'Иванов Иван',
    phone: '+7(900)000-00-00',
    shopId: 1,
    email: 'test@example.com',
);
$newUser = $client->users()->createUser($userDto); // Возвращает Users\DTO\UserDto

$user = $client->users()->getUserById(1);
$card = $client->cards()->getCardById(1);

$card = $client->cards()->getById(1); // Возвращает Cards\DTO\CardDto
$user = $client->users()->getById(1); // Возвращает Users\DTO\UserDto

// Сериализация в массив (для логирования/кэша)
$payload = $card->toArray();
```

## Денежные суммы (`moneyphp/money`)

Все денежные поля представлены типом `Money` (minor units). Пример в `CardDto`:

```php
use Money\Money;
use Money\Currency;

// В createFromArray:
$balance = MoneyParser::parse($data['balance'] ?? 0.0, $currency);

// В toArray (для JSON):
'balance'  => MoneyParser::toString($this->balance),
```

## Примеры

### Получить карту и вывести баланс

```php
use Money\Currency;
$card = $client->cards()->getById(1);
$balanceMoney = $card->balance->getAmount();
echo MoneyParser::convertMoneyToString($balanceMoney, new Currency('RUB')); // 509,7050
```

### Сериализация в массив (например, для кэша)

```php
$cached = $card->toArray();
$again = Cards\DTO\CardDto::createFromArray($cached);
```

## Ошибки

Все HTTP/протокольные ошибки приводятся к исключениям пространства имён `RarusBonus\Exceptions`:

- `ApiException` — ошибка, возвращённая сервером API (статус 4xx/5xx).
- `NetworkException` — ошибка сетевого уровня (таймаут, DNS, SSL и т. п.).
- `UnknownException` — непредусмотренная ошибка, не попавшая в другие категории.

```php
try {
    $user = $this->client->users()->getUserById($userId);
} catch (NetworkException $e) {
    // ошибка сетевого уровня
} catch (ApiClientException $e) {
    // ошибка, возвращённая сервером API
} catch (UnknownException $e) {
    // непредусмотренная ошибка
}
```
