<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\Role\User;

use PHPUnit\Framework\TestCase;
use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Shops;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Transactions;
use \Rarus\BonusServer\Auth;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Users\Transport
 */
class TransportTest extends TestCase
{
    /**
     * @var Cards\Transport\Role\Organization\Transport
     */
    private $cardTransport;
    /**
     * @var Users\Transport\Role\Organization\Transport
     */
    private $userTransport;

    /**
     * @var Shops\Transport\Transport
     */
    private $shopTransport;
    /**
     * @var Transactions\Transport\Role\Organization\Transport
     */
    private $transactionTransport;

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\User\Transport::list()
     */
    public function testList(): void
    {
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();

        $companyId = $apiClient->getAuthToken()->getCompanyId();

        // создаём карту
        $cardCode = (string)random_int(1000000, 100000000);
        $newCard = Cards\DTO\Fabric::createNewInstance($cardCode, $cardCode, \TestEnvironmentManager::getDefaultCurrency());
        $cardWithoutUser = $this->cardTransport->addNewCard($newCard);

        // добавляем пользователя
        $userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);
        $userPasswordHash = sha1('qwerty12345');
        $newUsersCollection = new Users\DTO\UserCollection();
        $newUsersCollection->attach(\DemoDataGenerator::createNewUserWithUserUidAndPassword($userUid, $userPasswordHash));
        $this->userTransport->importNewUsers($newUsersCollection);

        // привязываем карту к пользователю
        $importedUser = $this->userTransport->getByUserId(new Users\DTO\UserId($userUid));
        $card = $this->cardTransport->attachToUser($cardWithoutUser, $importedUser);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $cardsUserRoleTransport = Cards\Transport\Role\User\Fabric::getInstance($apiClient, \TestEnvironmentManager::getDefaultCurrency(), \TestEnvironmentManager::getMonologInstance());
        $cards = $cardsUserRoleTransport->list();
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\User\Transport::getBalanceInfo()
     */
    public function testGetBalanceInfo(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $cardWithoutUser = $this->cardTransport->activate($card);

        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        // добавляем пользователя
        $userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);
        $userPasswordHash = sha1('qwerty12345');

        $newUsersCollection = new Users\DTO\UserCollection();
        $newUsersCollection->attach(\DemoDataGenerator::createNewUserWithUserUidAndPassword($userUid, $userPasswordHash));
        $this->userTransport->importNewUsers($newUsersCollection);

        // привязываем карту к пользователю
        $importedUser = $this->userTransport->getByUserId(new Users\DTO\UserId($userUid));
        $card = $this->cardTransport->attachToUser($cardWithoutUser, $importedUser);

        // конструируем транзакции
        $trxCount = 100;
        for ($i = 0; $i < $trxCount; $i++) {
            $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        }

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $companyId = \TestEnvironmentManager::getInstanceForRoleOrganization()->getAuthToken()->getCompanyId();
        $userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPasswordHash);
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $cardsUserRoleTransport = Cards\Transport\Role\User\Fabric::getInstance($apiClient, \TestEnvironmentManager::getDefaultCurrency(), \TestEnvironmentManager::getMonologInstance());

        $cards = $cardsUserRoleTransport->list();
        foreach ($cards as $card) {
            $balance = $cardsUserRoleTransport->getBalanceInfo($card, $trxCount);
            $this->assertGreaterThan(0, $balance->getAvailable()->getAmount());
            $this->assertGreaterThan(0, $balance->getTotal()->getAmount());
        }
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->cardTransport = Cards\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->userTransport = Users\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->shopTransport = Shops\Transport\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->transactionTransport = Transactions\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}