<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;

print('сложный сценарий: активация карты из внешней ситсемы' . PHP_EOL);

/**
 * 1. Магазин выпустил N кард и завёл их в БС
 * 2. Пользователь получает карту в оффлайновом магазине.
 * 3. Позже, пользователь авторизуется на сайте в личном кабинете.
 * 4. Ищем карту по штрихкоду (/organization/card?page=1&per_page=1&calculate_count=false&barcode=*номер карты*)
 * 5. Получаем массив карт, где будет или 0 карт или 1.
 *    Если карт 0 - ошибка, если карт 1, то всё хорошо, такая карта в системе зарегистрирована, запоминаем её данные.
 * 6. Если у карты есть пользователь (заполнен user_id) тогда вызываем метод organization/user/*user_id* и сравниваем
 *    его email и phone  с этими же полями в анкете.
 *    Если совпали, то переходим к п. 8. Если не совпали, то пользователь пытается получить чужую карту - говорим, что такой нет.
 * 7. Если у карты нет пользователя то:
 *     - Регистрируем пользователя по анкете с реальным паролем в SHA1. методом /organization/user/upload.
 *     - Связываем карту с пользователем методом organization/card/attach{user_id, card_id}
 * 8. Если карта не была активирована - вызываем метод organization/card/card_id/activate
 */

$userInformation = [
    'name' => 'Михаил Гришин',
    'phone' => '+7978 888 22 22',
    'email' => 'grishi@rarus.ru',
];

$cardsTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$userTransport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// 1. выпускаем одну карту
$cardCode = (string)random_int(1000000, 100000000);
$newCard = Cards\DTO\Fabric::createNewInstance($cardCode, $cardCode, new \Money\Currency('RUB'));
$card = $cardsTransport->addNewCard($newCard);
print(sprintf('сard id: %s' . PHP_EOL, $card->getCardId()->getId()));
print(sprintf('сard code: %s' . PHP_EOL, $card->getCode()));

// 2. создаём пользователя и привязываем карту к пользователю (действия через АРМ кассира в магазине)
$newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
    'grishi-' . random_int(0, PHP_INT_MAX),
    $userInformation['name'],
    $userInformation['phone'],
    $userInformation['email']
);
$user = $userTransport->addNewUser($newUser);
print(sprintf('new user with id: %s' . PHP_EOL, $user->getUserId()->getId()));
$card = $cardsTransport->attachToUser($card, $user);
print(sprintf('attach card with id [%s] to user with id [%s]' . PHP_EOL, $card->getCardId()->getId(), $user->getUserId()->getId()));
print(sprintf('сard id: %s' . PHP_EOL, $card->getCardId()->getId()));
print(sprintf('сard user id: %s' . PHP_EOL, $card->getUserId() !== null ? $card->getUserId()->getId() : null));

// 3. пользователь авторизуется на сайте в ЛК и вводит номер карты
$userInputCardBarcode = $cardCode;

// 4. Ищем карту по штрихкоду (/organization/card?page=1&per_page=1&calculate_count=false&barcode=*номер карты*)
$cardFilter = new Cards\DTO\CardFilter();
$cardFilter->setBarcode($cardCode);
print('card filter: ' . Cards\Formatters\CardFilter::toUrlArguments($cardFilter) . PHP_EOL);
$cardsCollection = $cardsTransport->getByFilter($cardFilter);
// 5. Получаем массив карт, если такая карта в системе зарегистрирована, запоминаем её данные.
print ('cards found: ' . $cardsCollection->count() . PHP_EOL);
$cardsCollection->rewind();
$card = $cardsCollection->current();

// 6. Если у карты есть пользователь (заполнен user_id) тогда вызываем метод organization/user/*user_id* и сравниваем его email и phone  с этими же полями в анкете.
// Если совпали, то переходим к п. 8. Если не совпали, то пользователь пытается получить чужую карту - говорим, что такой нет.
if ($card->getUserId() !== null) {
    $currentUser = $userTransport->getByUserId($card->getUserId());
    print(sprintf('user with id: %s' . PHP_EOL, $currentUser->getUserId()->getId()));
    print(sprintf('- email: %s' . PHP_EOL, $currentUser->getEmail()));
    print(sprintf('- phone: %s' . PHP_EOL, $currentUser->getPhone()));

    if ($currentUser->getEmail() === $userInformation['email']) {
        // 8. Если карта не была активирована - вызываем метод organization/card/card_id/activate
        print(sprintf('сard id [%s] status is_active [%s]' . PHP_EOL, $card->getCardId()->getId(), $card->getCardStatus()->isActive()));
        if (!$card->getCardStatus()->isActive()) {
            $card = $cardsTransport->activate($card);
            print(sprintf('сard id [%s] status is_active [%s]' . PHP_EOL, $card->getCardId()->getId(), $card->getCardStatus()->isActive()));
        }
    }
}

//7. Если у карты нет пользователя то:
// *     - Регистрируем пользователя по анкете с реальным паролем в SHA1. методом /organization/user/upload.
// *     - Связываем карту с пользователем методом organization/card/attach{user_id, card_id}

// создаём карту без пользователя
$cardCode = (string)random_int(1000000, 100000000);
$newCard = Cards\DTO\Fabric::createNewInstance($cardCode, $cardCode, new \Money\Currency('RUB'));
$cardWithoutUser = $cardsTransport->addNewCard($newCard);

var_dump(Cards\Formatters\Card::toArray($cardWithoutUser));

$password = sha1('12345');
$userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);

$userCollection = new \Rarus\BonusServer\Users\DTO\UserCollection();
$userCollection->attach(
    \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
        'grishi-' . random_int(0, PHP_INT_MAX),
        'Михаил Гришин (импорт)',
        '+7978 888 22 22',
        'grishi@rarus.ru',
        null,
        null,
        $password,
        new \Rarus\BonusServer\Users\DTO\UserId($userUid),
        \Rarus\BonusServer\Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )
);
$userTransport->importNewUsers($userCollection);

// выбираем добавленного пользователя
$importedUser = $userTransport->getByUserId(new \Rarus\BonusServer\Users\DTO\UserId($userUid));
$cardWithoutUser = $cardsTransport->attachToUser($cardWithoutUser, $importedUser);
print(sprintf('attach card with id [%s] to user with id [%s]' . PHP_EOL, $card->getCardId()->getId(), $importedUser->getUserId()->getId()));
print(sprintf('сard id: %s' . PHP_EOL, $cardWithoutUser->getCardId()->getId()));
print(sprintf('сard user id: %s' . PHP_EOL, $cardWithoutUser->getUserId() !== null ? $cardWithoutUser->getUserId()->getId() : null));