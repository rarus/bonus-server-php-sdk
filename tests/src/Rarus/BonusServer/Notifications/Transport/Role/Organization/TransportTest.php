<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Tests\Notifications\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Notifications\DTO\NewNotification;
use Rarus\BonusServer\Notifications\DTO\NotificationId;
use Rarus\BonusServer\Notifications\DTO\NotificationOrganizationFilter;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users\DTO\UserCollection;
use Rarus\BonusServer\Users\DTO\UserId;


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
    private $notificationTransport;
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
    public function testById()
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
        $newNotificationCreated = $this->notificationTransport->add($newNotification);

        $this->assertEquals($newNotification->getNotificationId()->getId(), $newNotificationCreated->getNotificationId()->getId());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
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
        $this->notificationTransport->add($newNotification);

        $filter = new NotificationOrganizationFilter();
        $filter->setUserId(new UserId($newUser->getUserId()->getId()));
        $updatedNotificationCollection = $this->notificationTransport->list($filter, new Pagination(100, 1));

        $this->assertEquals(1, $updatedNotificationCollection->getPagination()->getResultItemsCount());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->notificationTransport = \Rarus\BonusServer\Notifications\Transport\Role\Organization\Fabric::getInstance(
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
