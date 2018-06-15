<?php
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Auth;

$companyId = $apiClient->getAuthToken()->getCompanyId();

$cardsOrganizationRoleTransport = Cards\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$userOrganizationTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// создаём карту
$cardCode = (string)random_int(1000000, 100000000);
$newCard = Cards\DTO\Fabric::createNewInstance($cardCode, $cardCode, new \Money\Currency('RUB'));
$cardWithoutUser = $cardsOrganizationRoleTransport->addNewCard($newCard);
print(sprintf('сard id: %s' . PHP_EOL, $cardWithoutUser->getCardId()->getId()));
print(sprintf('сard code: %s' . PHP_EOL, $cardWithoutUser->getCode()));

// добавляем пользователя
$userPassword = sha1('12345');
$userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);
$newUsersCollection = new Users\DTO\UserCollection();
$newUsersCollection->attach(
    Users\DTO\Fabric::createNewInstance(
        $userUid,
        'Михаил Гришин (импорт)',
        '+7978 888 22 22',
        'grishi@rarus.ru',
        null,
        null,
        $userPassword,
        new Users\DTO\UserId($userUid),
        Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )
);
$userOrganizationTransport->importNewUsers($newUsersCollection);

// привязываем карту к пользователю
$importedUser = $userOrganizationTransport->getByUserId(new Users\DTO\UserId($userUid));
$card = $cardsOrganizationRoleTransport->attachToUser($cardWithoutUser, $importedUser);
print(sprintf('attach card with id [%s] to user with id [%s]' . PHP_EOL, $card->getCardId()->getId(), $importedUser->getUserId()->getId()));
print(sprintf('сard id: %s' . PHP_EOL, $card->getCardId()->getId()));
print(sprintf('сard user id: %s' . PHP_EOL, $card->getUserId() !== null ? $card->getUserId()->getId() : null));

// авторизуемся на бонусном сервере под учётной записью пользователя
$userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPassword);
$userAuthToken = $apiClient->getNewAuthToken($userCredentials);
$apiClient->setAuthToken($userAuthToken);

$cardsUserRoleTransport = Cards\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$cards = $cardsUserRoleTransport->list();
print('cards list from user:' . PHP_EOL);
foreach ($cards as $card) {
    print(sprintf('card [%s]' . PHP_EOL, $card->getCardId()->getId()));
}