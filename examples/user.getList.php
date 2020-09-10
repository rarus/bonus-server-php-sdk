<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users;
use Rarus\BonusServer\Auth;

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

$users = $userOrganizationTransport->list(new Users\DTO\UserFilter(), new Pagination(10, 1));
print('users list:' . PHP_EOL);
foreach ($users->getUsersCollection() as $user) {
    print(sprintf('user [%s]' . PHP_EOL, $user->getLogin()));
}

print(sprintf('page [%s]' . PHP_EOL, $users->getPagination()->getPageNumber()));
