<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use \Rarus\BonusServer\Cards;
use Rarus\BonusServer\Exceptions\ApiClientException;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Cards\Transport
 */
class TransportTest extends TestCase
{
    /**
     * @var Transport
     */
    private $cardTransport;
    /**
     * @var \Rarus\BonusServer\Users\Transport\Role\Organization\Transport
     */
    private $userTransport;

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::list()
     */
    public function testListMethod(): void
    {
        $newCardCount = 10;
        $newCardCollection = \DemoDataGenerator::createNewCardCollection($newCardCount);
        foreach ($newCardCollection as $newCard) {
            $this->cardTransport->addNewCard($newCard);
        }
        $cardCollection = $this->cardTransport->list();

        $this->assertGreaterThan($newCardCount, $cardCollection->count());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByBarcode()
     */
    public function testAddNewCardMethod(): void
    {
        $barcode = (string)random_int(1000000, 100000000);

        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            $barcode,
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);
        $cardFromServer = $this->cardTransport->getByBarcode(new Cards\DTO\Barcode\Barcode($barcode));

        $this->assertEquals($newCard->getCode(), $cardFromServer->getCode());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByUser()
     */
    public function testGetByUserMethod(): void
    {
        $newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . random_int(0, PHP_INT_MAX),
            'Михаил Гришин',
            '+7978 888 22 21',
            'grishi@rarus.ru'
        );
        $user = $this->userTransport->addNewUser($newUser);
        $attachedCards = $this->cardTransport->getByUser($user);
        $attachedCardsCount = $attachedCards->count();
        $newCardsCount = 2;

        // добавляем ещё карт
        $newCards = \DemoDataGenerator::createNewCardCollection($newCardsCount);

        foreach ($newCards as $newCard) {
            $card = $this->cardTransport->addNewCard($newCard);
            $this->cardTransport->attachToUser($card, $user);
        }
        $attachedCards = $this->cardTransport->getByUser($user);
        $totalCardsCount = $attachedCards->count();

        $this->assertEquals($totalCardsCount, $attachedCardsCount + $newCardsCount);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     */
    public function testGetByCardIdMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $cardClone = $this->cardTransport->getByCardId($card->getCardId());
        $this->assertEquals($cardClone->getCardId()->getId(), $card->getCardId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::activate()
     */
    public function testActivateMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $activatedCard = $this->cardTransport->activate($card);
        $this->assertEquals(true, $activatedCard->getCardStatus()->isActive());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::deactivate()
     */
    public function testDeactivateMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $deactivatedCard = $this->cardTransport->deactivate($card);
        $this->assertEquals(false, $deactivatedCard->getCardStatus()->isActive());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::update()
     *
     */
    public function testUpdateMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $card->setName('new-card-name');
        $updatedCard = $this->cardTransport->update($card);

        $this->assertEquals('new-card-name', $updatedCard->getName());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::delete()
     */
    public function testDeleteMethod(): void
    {
        $barcode = (string)random_int(1000000, 100000000);
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            $barcode,
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);
        $this->cardTransport->delete($card);

        $cardFilter = new Cards\DTO\CardFilter();
        $cardFilter
            ->setBarcode(new Cards\DTO\Barcode\Barcode($barcode));
        $emptyResult = $this->cardTransport->getByFilter($cardFilter);
        $this->assertEquals(0, $emptyResult->count());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::block()
     *
     */
    public function testBlockMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $blockedCard = $this->cardTransport->block($card, 'причина блокировки');

        $this->assertEquals(true, $blockedCard->getCardStatus()->isBlocked());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::block()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::unblock()
     *
     */
    public function testUnblockMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $blockedCard = $this->cardTransport->block($card, 'причина блокировки');

        $unblockedCard = $this->cardTransport->unblock($blockedCard);

        $this->assertEquals(false, $unblockedCard->getCardStatus()->isBlocked());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::isCardCanLevelUp()
     */
    public function testIsCardCanLevelUpMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));

        $card = $this->cardTransport->addNewCard($newCard);
        $activatedCard = $this->cardTransport->activate($card);

        $result = $this->cardTransport->isCardCanLevelUp($activatedCard);

        $this->assertEquals(\is_bool($result), true);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::levelUp()
     */
    public function testCanLevelUpMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));

        $card = $this->cardTransport->addNewCard($newCard);
        $activatedCard = $this->cardTransport->activate($card);
        $updatedCard = $this->cardTransport->levelUp($activatedCard);

        $this->assertNotEquals($activatedCard->getCardLevelId()->getId(), $updatedCard->getCardLevelId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByFilter()
     */
    public function testGetByFilter(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $cardFilter = new Cards\DTO\CardFilter();
        $cardFilter->setBarcode($card->getBarcode());

        $cardsCollection = $this->cardTransport->getByFilter($cardFilter);
        $filteredCard = $cardsCollection->current();

        $this->assertEquals($card->getBarcode()->getCode(), $filteredCard->getBarcode()->getCode());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByBarcode()
     */
    public function testGetByBarcode(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $filteredCard = $this->cardTransport->getByBarcode($card->getBarcode());

        $this->assertEquals($card->getBarcode()->getCode(), $filteredCard->getBarcode()->getCode());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::attachToUser()
     */
    public function testAttachToUser(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());

        $card = $this->cardTransport->addNewCard($newCard);

        $newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . random_int(0, PHP_INT_MAX),
            'Михаил Гришин',
            '+7978 888 22 22',
            'grishi@rarus.ru'
        );

        $user = $this->userTransport->addNewUser($newUser);

        $updatedCard = $this->cardTransport->attachToUser($card, $user);

        $this->assertEquals($updatedCard->getUserId()->getId(), $user->getUserId()->getId());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->cardTransport = Fabric::getInstance(
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