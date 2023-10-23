<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Tests\Users\Transport\Role\User;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Auth;
use Rarus\BonusServer\Users;

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
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testCurrentMethod(): void
    {
        // добавляем пользователя
        $userUid = 'grishi-uid-' . \random_int(0, PHP_INT_MAX);
        $userPasswordHash = sha1('qwerty12345');
        $newUser = \DemoDataGenerator::createNewUserWithUserUidAndPassword($userUid, $userPasswordHash);

        $newUsersCollection = new Users\DTO\UserCollection();
        $newUsersCollection->attach($newUser);
        $this->userTransport->importNewUsers($newUsersCollection);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $companyId = \TestEnvironmentManager::getInstanceForRoleOrganization()->getAuthToken()->getCompanyId();
        $userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $userUserRoleTransport = Users\Transport\Role\User\Fabric::getInstance($apiClient, \TestEnvironmentManager::getDefaultCurrency(), \TestEnvironmentManager::getMonologInstance());
        $user = $userUserRoleTransport->current();

        $this->assertEquals($user->getEmail(), $newUser->getEmail());
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
