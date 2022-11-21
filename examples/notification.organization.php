<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Notifications\DTO\NewNotification;
use Rarus\BonusServer\Notifications\DTO\NotificationId;
use Rarus\BonusServer\Notifications\DTO\NotificationOrganizationFilter;
use Rarus\BonusServer\Notifications\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users;

$companyId = $apiClient->getAuthToken()->getCompanyId();

$notificationsTransport = Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);
$userOrganizationTransport = Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

// добавляем пользователя
$userPassword = sha1('12345');
$userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);
$newUsersCollection = new Users\DTO\UserCollection();
$newUsersCollection->attach(
    Users\DTO\Fabric::createNewInstance(
        $userUid,
        'Ивлев Андрей (импорт)',
        '+7900 000 00 00',
        'ivlean@rarus.ru',
        null,
        null,
        $userPassword,
        new Users\DTO\UserId($userUid),
        Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
    )->setUserId(new Users\DTO\UserId($userUid))
);
$userOrganizationTransport->importNewUsers($newUsersCollection);

// Добавляем новое уведомление
$newNotificationId = new NotificationId('');
$newNotification = new NewNotification($newNotificationId, 'title', 'text');
$newNotification->setUserId(new Users\DTO\UserId($userUid));
$notificationsTransport->add($newNotification);

// Получаем уведомления
$filter = new NotificationOrganizationFilter();
$filter->setUserId(new Users\DTO\UserId($userUid));
$notificationCollection = $notificationsTransport->list($filter, new Pagination(10, 1));

if ($notificationCollection->getNotificationCollection()->count()) {
    foreach ($notificationCollection->getNotificationCollection() as $notification) {
        print_r(sprintf("notification %s \n", $notification->getNotificationId()->getId()));
        print_r(sprintf("title %s \n", $notification->getTitle()));
        print_r(sprintf("text %s \n", $notification->getText()));
    }
}
