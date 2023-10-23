<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Tests\Users\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users\DTO\UserFilter;
use Rarus\BonusServer\Users\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Users\Transport\Role\Organization\Transport;

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
     * @var Transport
     */
    private $userTransport;
    /**
     * @var Cards\Transport\Role\Organization\Transport
     */
    private $cardTransport;

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testGetByUserIdMethod(): void
    {
        // гарантированно создаём карту для привязки к пользователю, если карт нет, то юзера не создать
        $newFreeCard = \DemoDataGenerator::createNewCard();
        $this->cardTransport->addNewCard($newFreeCard);

        $user = $this->userTransport->addNewUser(\DemoDataGenerator::createNewUser());

        $user2 = $this->userTransport->getByUserId($user->getUserId());

        $this->assertEquals($user->getUserId()->getId(), $user2->getUserId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserMethod(): void
    {
        // гарантированно создаём карту для привязки к пользователю, если карт нет, то юзера не создать
        $newFreeCard = \DemoDataGenerator::createNewCard();
        $this->cardTransport->addNewCard($newFreeCard);
        // создаём нового юзера
        $newUser = \DemoDataGenerator::createNewUser();
        // пробуем его добавить
        $user = $this->userTransport->addNewUser($newUser);
        $this->assertEquals($newUser->getEmail(), $user->getEmail());
        $this->assertEquals($newUser->getBirthdate()->format('d.m.Y H:i:s'), $user->getBirthdate()->format('d.m.Y H:i:s'));
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserWithSummerBirthdayMethod(): void
    {
        // гарантированно создаём карту для привязки к пользователю, если карт нет, то юзера не создать
        $newFreeCard = \DemoDataGenerator::createNewCard();
        $this->cardTransport->addNewCard($newFreeCard);

        $newUser = \DemoDataGenerator::createNewUserWithSummerBirthday();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals($newUser->getEmail(), $user->getEmail());
        $this->assertEquals($newUser->getBirthdate()->format('d.m.Y H:i:s'), $user->getBirthdate()->format('d.m.Y H:i:s'));
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserWithNowDateTimeBirthdayMethod(): void
    {
        // гарантированно создаём карту для привязки к пользователю, если карт нет, то юзера не создать
        $newFreeCard = \DemoDataGenerator::createNewCard();
        $this->cardTransport->addNewCard($newFreeCard);

        $newUser = \DemoDataGenerator::createNewUserWithNowDateTimeBirthday();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals($newUser->getEmail(), $user->getEmail());
        $this->assertEquals($newUser->getBirthdate()->format('d.m.Y H:i:s'), $user->getBirthdate()->format('d.m.Y H:i:s'));
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserWithWinterBirthdayMethod(): void
    {
        // гарантированно создаём карту для привязки к пользователю, если карт нет, то юзера не создать
        $newFreeCard = \DemoDataGenerator::createNewCard();
        $this->cardTransport->addNewCard($newFreeCard);

        $newUser = \DemoDataGenerator::createNewUserWithWinterBirthday();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals($newUser->getEmail(), $user->getEmail());
        $this->assertEquals($newUser->getBirthdate()->format('d.m.Y H:i:s'), $user->getBirthdate()->format('d.m.Y H:i:s'));
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserWithoutBirthday(): void
    {
        // гарантированно создаём карту для привязки к пользователю, если карт нет, то юзера не создать
        $newFreeCard = \DemoDataGenerator::createNewCard();
        $this->cardTransport->addNewCard($newFreeCard);

        $newUser = \DemoDataGenerator::createNewUserWithoutBirthday();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals(null, $user->getBirthdate());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUserAndAttachFreeCard()
     */
    public function testAddNewUserAndAttachFreeCardMethod(): void
    {
        // гарантированно создаём карту для привязки к пользователю, если карт нет, то юзера не создать
        $newFreeCard = \DemoDataGenerator::createNewCard();
        $this->cardTransport->addNewCard($newFreeCard);

        $newUser = \DemoDataGenerator::createNewUser();
        $user = $this->userTransport->addNewUserAndAttachFreeCard($newUser);
        // юзера вычитали корректного
        $this->assertEquals($user->getLogin(), $newUser->getLogin());

        $cards = $this->cardTransport->getByUser($user);
        // у него одна привязанная карта
        $attachedCard = $cards->current();
        $this->assertEquals($user->getUserId()->getId(), $attachedCard->getUserId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::importNewUsers()
     */
    public function testImportNewUsers(): void
    {
        $newUserCollection = \DemoDataGenerator::createNewUserWithUserUidAndPasswordCollection(5);
        $this->userTransport->importNewUsers($newUserCollection);
        foreach ($newUserCollection as $newUser) {
            $addedUser = $this->userTransport->getByUserId($newUser->getUserId());
            $this->assertEquals($addedUser->getEmail(), $newUser->getEmail());
        }
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testImportNewUsersAndCards(): void
    {
        $newUserCollection = \DemoDataGenerator::createNewUserWithUserUidAndPasswordCollection(1);
        foreach ($newUserCollection as $user) {
            $card = Cards\DTO\Fabric::createNewInstance(
                md5('1'),
                (string)random_int(1000000, 100000000),
                new \Money\Currency('RUB')
            )->setCardId(new Cards\DTO\CardId());
            $newUserCardCollection = new Cards\DTO\CardCollection();
            $newUserCardCollection->attach($card);

            $user->setName('testImportNewUsersAndCards8');
            $user->setCardCollection($newUserCardCollection);
        }
        $this->userTransport->importNewUsers($newUserCollection, Cards\DTO\UniqueField::setCode(), true);
        foreach ($newUserCollection as $newUser) {
            $addedUser = $this->userTransport->getByUserId($newUser->getUserId());
            $this->assertEquals($addedUser->getEmail(), $newUser->getEmail());
        }
    }

    public function testUpdateMethod(): void
    {
        $newUser = \DemoDataGenerator::createNewUserWithoutBirthday();
        $user = $this->userTransport->addNewUser($newUser);
        $user->setName('Updated user name');
        $updatedUser = $this->userTransport->update($user);
        $this->assertEquals($updatedUser->getName(), 'Updated user name');
    }

    public function testDeleteMethod(): void
    {
        $newUser = \DemoDataGenerator::createNewUserWithoutBirthday();
        $user = $this->userTransport->addNewUser($newUser);
        $this->userTransport->delete($user);

        $emptyResult = null;

        try {
            $emptyResult = $this->userTransport->getByUserId($user->getUserId());
        } catch (NetworkException $e) {
        } catch (ApiClientException $e) {
        } catch (UnknownException $e) {
        }

        $this->assertNull($emptyResult);
    }

    public function testListMethod(): void
    {
        $userUUID = random_int(0, PHP_INT_MAX);
        $newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'ivlean-' . $userUUID,
            'Ивлев Андрей | ' . $userUUID,
            '+7 900 000 00 00',
            sprintf('ivlean-%s@rarus.ru', $userUUID)
        );
        $this->userTransport->addNewUser($newUser);

        $userFilter = new UserFilter();
        $userFilter->setLogin('ivlean-' . $userUUID);
        $users = $this->userTransport->list($userFilter, new Pagination());

        $this->assertEquals(1, $users->getPagination()->getResultItemsCount());
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

        $this->userTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
