<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\Role\User;

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Auth;

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
     * @var Users\Transport\Role\Organization\Transport
     */
    private $userTransportOrganizationRole;
    /**
     * @var Cards\Transport\Role\Organization\Transport
     */
    private $cardTransportOrganizationRole;

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\User\Transport::list()
     */
    public function testList(): void
    {
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();

        $companyId = $apiClient->getAuthToken()->getCompanyId();

        // создаём карту
        $cardCode = (string)random_int(1000000, 100000000);
        $newCard = Cards\DTO\Fabric::createNewInstance($cardCode, $cardCode, new \Money\Currency('RUB'));
        $cardWithoutUser = $this->cardTransportOrganizationRole->addNewCard($newCard);

        // добавляем пользователя
        $userPassword = sha1('12345');
        $userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);
        $newUsersCollection = new Users\DTO\UserCollection();
        $newUsersCollection->attach(
            Users\DTO\Fabric::createNewInstance(
                $userUid,
                'Михаил Гришин (импорт)',
                '+7978 888 22 22',
                'grishi@rarus.ru',
                null,
                null,
                $userPassword,
                new Users\DTO\UserId($userUid),
                Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
            )
        );
        $this->userTransportOrganizationRole->importNewUsers($newUsersCollection);

        // привязываем карту к пользователю
        $importedUser = $this->userTransportOrganizationRole->getByUserId(new Users\DTO\UserId($userUid));
        $card = $this->cardTransportOrganizationRole->attachToUser($cardWithoutUser, $importedUser);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPassword);
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $cardsUserRoleTransport = Cards\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), \TestEnvironmentManager::getMonologInstance());
        $cards = $cardsUserRoleTransport->list();
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->userTransportOrganizationRole = Users\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );

        $this->cardTransportOrganizationRole = Cards\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()

        );
    }
}