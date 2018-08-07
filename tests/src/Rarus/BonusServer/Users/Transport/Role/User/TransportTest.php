<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport\Role\User;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Users;
use Rarus\BonusServer\Auth;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Users\Transport
 */
class TransportTest extends TestCase
{
    /**
     * @var \Rarus\BonusServer\ApiClient
     */
    private $apiClient;
    /**
     * @var Users\Transport\Role\Organization\Transport
     */
    private $userTransport;

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\User\Transport::current()
     */
    public function testCurrentMethod(): void
    {
        // добавляем пользователя
        $userUid = 'grishi-uid-' . \random_int(0, PHP_INT_MAX);
        $userPasswordHash = sha1('qwerty12345');

        $newUsersCollection = new Users\DTO\UserCollection();
        $newUsersCollection->attach(\DemoDataGenerator::createNewUserWithUserUidAndPassword($userUid, $userPasswordHash));
        $this->userTransport->importNewUsers($newUsersCollection);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $companyId = \TestEnvironmentManager::getInstanceForRoleOrganization()->getAuthToken()->getCompanyId();
        $userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $userUserRoleTransport = Users\Transport\Role\User\Fabric::getInstance($apiClient, \TestEnvironmentManager::getDefaultCurrency(), \TestEnvironmentManager::getMonologInstance());
        $userUserRoleTransport->current();
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->userTransport = Users\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}