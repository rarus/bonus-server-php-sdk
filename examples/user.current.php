<?php
declare(strict_types=1);
require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Users;
use Rarus\BonusServer\Auth;

// транзакция котора отражает прожажу, происходит списание бонусов
$companyId = $apiClient->getAuthToken()->getCompanyId();

$userOrganizationTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

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

// авторизуемся на бонусном сервере под учётной записью пользователя
$userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPassword);
$userAuthToken = $apiClient->getNewAuthToken($userCredentials);
$apiClient->setAuthToken($userAuthToken);

$usersUserRoleTransport = Users\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

var_dump(Users\Formatters\PersonalInfo::toArray($usersUserRoleTransport->current()));