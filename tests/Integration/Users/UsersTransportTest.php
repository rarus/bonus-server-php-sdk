<?php

namespace Rarus\LMS\SDK\Tests\Integration\Users;

use PHPUnit\Framework\TestCase;
use Random\RandomException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\InvalidArgumentException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Users\DTO\Fabric;
use Rarus\LMS\SDK\Users\DTO\UserDto;
use TestEnvironmentManager;

class UsersTransportTest extends TestCase
{
    private Client $client;

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     * @throws RandomException
     * @throws InvalidArgumentException
     */
    public function test_add_new_user(): void
    {
        $newUser = Fabric::createNewInstance(
            name: 'integration_test',
            phone: '+79'.random_int(100000000, 999999999),
            shopId: 1
        );
        $newUser = $this->client->users()->addNewUser($newUser);
        $this->assertInstanceOf(UserDto::class, $newUser);
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function test_get_user_by_id(): void
    {
        $userId = 1;
        $user = $this->client->users()->getUserById($userId);
        $this->assertInstanceOf(UserDto::class, $user);
    }

    /**
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = TestEnvironmentManager::getInstance();
    }
}
