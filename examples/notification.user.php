<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Notifications\DTO\NewNotification;
use Rarus\BonusServer\Notifications\DTO\NotificationId;
use Rarus\BonusServer\Notifications\DTO\NotificationOrganizationFilter;
use Rarus\BonusServer\Notifications\DTO\NotificationUserFilter;
use Rarus\BonusServer\Notifications\Formatters\NotificationFilter;
use Rarus\BonusServer\Notifications\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users;

// Добавляем пользователя
$userOrganizationTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$userUid = 'ivlean-uid-test' . \random_int(0, PHP_INT_MAX);
$userPasswordHash = sha1('qwerty12345');
$newUsersCollection = new Users\DTO\UserCollection();
$newUsersCollection->attach(
    Users\DTO\Fabric::createNewInstance(
        $userUid,
        'Михаил Гришин | ' . $userUid,
        '+79788882222',
        "grishi$userUid@rarus.ru",
        null,
        null,
        $userPasswordHash,
        new Users\DTO\UserId($userUid),
        Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )
);
$userOrganizationTransport->importNewUsers($newUsersCollection);

// Добавляем новое уведомление
$notificationsTransport = Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$newNotificationId = new NotificationId('');
$newNotification = new NewNotification($newNotificationId, 'title user', 'text');
$newNotification->setUserId(new Users\DTO\UserId($userUid));
$notificationsTransport->add($newNotification);

// авторизуемся на бонусном сервере под учётной записью пользователя
$companyId = $apiClient->getAuthToken()->getCompanyId();
$userCredentials = \Rarus\BonusServer\Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
$userAuthToken = $apiClient->getNewAuthToken($userCredentials);
$apiClient->setAuthToken($userAuthToken);

// Получаем уведомления
$filter = new NotificationUserFilter();
$notificationsUserRoleTransport = \Rarus\BonusServer\Notifications\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$notificationCollection = $notificationsUserRoleTransport->list($filter, new Pagination(10, 1));

if ($notificationCollection->getNotificationCollection()->count()) {
    foreach ($notificationCollection->getNotificationCollection() as $notification) {
        print_r(sprintf("notification %s \n", $notification->getNotificationId()->getId()));
        print_r(sprintf("title %s \n", $notification->getTitle()));
        print_r(sprintf("text %s \n", $notification->getText()));
    }
}
