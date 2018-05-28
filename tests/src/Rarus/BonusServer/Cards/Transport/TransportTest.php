<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport;

use \Rarus\BonusServer\Cards;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Cards\Transport
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
    private $cardTransport;

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::list()
     */
    public function testListMethod(): void
    {
        $shopCollection = $this->cardTransport->list();
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     */
    public function testAddNewCardMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
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
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::activate()
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
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::deactivate()
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
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::update()
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
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::delete()
     *
     */
    public function testDeleteMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard($newCard);

        $this->cardTransport->delete($card);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::block()
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
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::block()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::unblock()
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
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::isCardCanLevelUp()
     */
    public function testiIsCardCanLevelUpMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));

        $card = $this->cardTransport->addNewCard($newCard);
        $activatedCard = $this->cardTransport->activate($card);

        $this->cardTransport->isCardCanLevelUp($activatedCard);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::levelUp()
     */
    public function testCanLevelUpMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance('12345987654321', (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));

        $card = $this->cardTransport->addNewCard($newCard);
        $activatedCard = $this->cardTransport->activate($card);

        $this->cardTransport->levelUp($activatedCard);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByFilter()
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

        $this->assertEquals($card->getBarcode(), $filteredCard->getBarcode());
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
    }
}