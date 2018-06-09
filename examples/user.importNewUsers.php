<?php
declare(strict_types=1);
require_once __DIR__ . '/init.php';

$userCollection = new \Rarus\BonusServer\Users\DTO\UserCollection();
$userCollection->attach(
    \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
        'grishi-' . random_int(0, PHP_INT_MAX),
        'Михаил Гришин 1',
        '+7978 888 22 22',
        'grishi@rarus.ru',
        null,
        null,
        'passs-hash-1',
        new \Rarus\BonusServer\Users\DTO\UserId('grishi-uid-' . random_int(0, PHP_INT_MAX)),
        \Rarus\BonusServer\Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )
);
$userCollection->attach(
    \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
        'grishi-' . random_int(0, PHP_INT_MAX),
        'Михаил Гришин 2',
        '+7978 888 22 22',
        'grishi@rarus.ru',
        null,
        null,
        'passs-hash-1',
        new \Rarus\BonusServer\Users\DTO\UserId('grishi-uid-' . random_int(0, PHP_INT_MAX)),
        \Rarus\BonusServer\Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )
);
$userCollection->attach(
    \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
        'grishi-' . random_int(0, PHP_INT_MAX),
        'Михаил Гришин 3',
        '+7978 888 22 22',
        'grishi@rarus.ru',
        null,
        null,
        'passs-hash-1',
        new \Rarus\BonusServer\Users\DTO\UserId('grishi-uid-' . random_int(0, PHP_INT_MAX)),
        \Rarus\BonusServer\Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )
);

print (sprintf('users count: %d' . PHP_EOL, $userCollection->count()));

$transport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$transport->importNewUsers($userCollection);
