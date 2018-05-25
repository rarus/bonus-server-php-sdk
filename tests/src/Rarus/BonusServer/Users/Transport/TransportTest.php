<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport;

use \Rarus\BonusServer\Cards;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Users\Transport
 */
class TransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rarus\BonusServer\ApiClient
     */
    private $apiClient;
    /**
     * @var Transport
     */
    private $userTransport;

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Transport::addNewUser()
     */
    public function testGetByUserIdMethod(): void
    {
        $newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . random_int(0, PHP_INT_MAX),
            'Михаил Гришин',
            '+7978 888 22 22',
            'grishi@rarus.ru'
        );

        $user = $this->userTransport->addNewUser($newUser);

        $user2 = $this->userTransport->getByUserId($user->getUserId());

        $this->assertEquals($user->getUserId()->getId(), $user2->getUserId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Transport::addNewUser()
     */
    public function testAddNewUserMethod(): void
    {

        $newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . random_int(0, PHP_INT_MAX),
            'Михаил Гришин',
            '+7978 888 22 22',
            'grishi@rarus.ru'
        );

        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals('grishi@rarus.ru', $user->getEmail());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->userTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}