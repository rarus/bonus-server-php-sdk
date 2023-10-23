<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Tests\Notifications\Transport\Role\User;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Auth\Fabric;
use Rarus\BonusServer\Notifications\DTO\NewNotification;
use Rarus\BonusServer\Notifications\DTO\NotificationId;
use Rarus\BonusServer\Notifications\DTO\NotificationUserFilter;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users\DTO\UserCollection;


/**
 * Class TransportTest
 *
 * @package src\Rarus\BonusServer\Segments\Transport\Role\Organization
 */
class TransportTest extends TestCase
{
    /**
     * @var \Rarus\BonusServer\Notifications\Transport\Role\Organization\Transport
     */
    private $notificationOrganizationTransport;
    /**
     * @var \Rarus\BonusServer\Users\Transport\Role\Organization\Transport
     */
    private $userTransport;

    /**
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Exception
     */
    public function testList()
    {
        // добавляем пользователя
        $userUid = 'ivlean-uid-test' . \random_int(0, PHP_INT_MAX);
        $userPasswordHash = sha1('qwerty12345');
        $newUser = \DemoDataGenerator::createNewUserWithUserUidAndPassword($userUid, $userPasswordHash);
        $newUsersCollection = new UserCollection();
        $newUsersCollection->attach($newUser);
        $this->userTransport->importNewUsers($newUsersCollection);

        // Добавляем уведомление
        $notificationId = new NotificationId('834060cd-429a-4762-88b4-558738d417f');
        $newNotification = new NewNotification($notificationId, 'title', 'template text');
        $newNotification->setUserId($newUser->getUserId());
        $this->notificationOrganizationTransport->add($newNotification);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $companyId = \TestEnvironmentManager::getInstanceForRoleOrganization()->getAuthToken()->getCompanyId();
        $userCredentials = Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $notificationTransportRoleUser = \Rarus\BonusServer\Notifications\Transport\Role\User\Fabric::getInstance(
            $apiClient,
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $filter = new NotificationUserFilter();
        $pagination = new Pagination();
        $notifications = $notificationTransportRoleUser->list($filter, $pagination);

        $this->assertEquals(1, $notifications->getNotificationCollection()->count());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Exception
     */
    public function testRead()
    {
        // добавляем пользователя
        $userUid = 'ivlean-uid-test' . \random_int(0, PHP_INT_MAX);
        $userPasswordHash = sha1('qwerty12345');
        $newUser = \DemoDataGenerator::createNewUserWithUserUidAndPassword($userUid, $userPasswordHash);
        $newUsersCollection = new UserCollection();
        $newUsersCollection->attach($newUser);
        $this->userTransport->importNewUsers($newUsersCollection);

        // Добавляем уведомление
        $notificationId = new NotificationId('notification-uid-' . \random_int(0, PHP_INT_MAX));
        $newNotification = new NewNotification($notificationId, 'title', 'template text');
        $newNotification->setUserId($newUser->getUserId());
        $this->notificationOrganizationTransport->add($newNotification);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $companyId = \TestEnvironmentManager::getInstanceForRoleOrganization()->getAuthToken()->getCompanyId();
        $userCredentials = Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $notificationTransportRoleUser = \Rarus\BonusServer\Notifications\Transport\Role\User\Fabric::getInstance(
            $apiClient,
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );

        $notificationTransportRoleUser->read($notificationId);
        $filter = new NotificationUserFilter();
        $pagination = new Pagination();
        $notifications = $notificationTransportRoleUser->list($filter, $pagination);
        $notification = $notifications->getNotificationCollection()->current();

        $this->assertTrue($notification->isRead());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->notificationOrganizationTransport = \Rarus\BonusServer\Notifications\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->notificationUserTransport = \Rarus\BonusServer\Notifications\Transport\Role\User\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->userTransport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
