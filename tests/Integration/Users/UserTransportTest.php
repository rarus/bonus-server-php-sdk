<?php

namespace Rarus\LMS\SDK\Tests\Integration\Users;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Random\RandomException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\RuntimeException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Users\DTO\Factory;
use Rarus\LMS\SDK\Users\DTO\UserCityDto;
use Rarus\LMS\SDK\Users\DTO\UserDto;
use TestEnvironmentManager;

class UserTransportTest extends TestCase
{
    private Client $client;

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     * @throws RandomException
     * @throws RuntimeException
     */
    public function test_add_new_user(): void
    {
        $newUser = Factory::create()
            ->withName('integration_test')
            ->withPhone('+79' . random_int(100000000, 999999999))
            ->withShopId('ext_1')
            ->withCity(
                new UserCityDto(
                    name: 'Рязань'
                )
            )
            ->build();

        $newUser = $this->client->users()->addNewUser($newUser);
        $this->assertInstanceOf(UserDto::class, $newUser);
    }

    public function test_update_user(): void
    {
        $userId = 1;
        $userDto = $this->client->users()->getUserById($userId);

        $updateUser = Factory::create()->fromDto($userDto)
            ->withName('integration_test2')
            ->withShopId(null)
            ->build();
        $this->client->users()->updateUser($updateUser);

        $updatedUser = $this->client->users()->getUserById($userId);

        $this->assertEquals($updatedUser->name, $updateUser->name);
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function test_get_user_by_id(): void
    {
        $userId = 2;
        $userDto = $this->client->users(0)->getUserById($userId, true);
        $this->assertInstanceOf(UserDto::class, $userDto);
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function test_get_user_by_phone(): void
    {
        $userDto = $this->client->users(0)->getUserByPhone('79000000001');
        $this->assertInstanceOf(UserDto::class, $userDto);
    }

    /**
     * @throws UnknownException
     * @throws ApiClientException
     * @throws NetworkException
     */
    public function test_get_properties(): void
    {
        $props = $this->client->users()->getUserProperties();
        $this->assertGreaterThan(0, count($props));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = TestEnvironmentManager::getInstance();
    }
}
