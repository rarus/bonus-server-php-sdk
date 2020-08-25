<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\Role\Organization;

use Money\Money;
use PHPUnit\Framework\TestCase;
use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Shops;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Transport\DTO\Pagination;

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
     * @var \Rarus\BonusServer\Shops\Transport\Role\Organization\Transport
     */
    private $shopTransport;
    /**
     * @var \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport
     */
    private $transactionTransport;

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getPaymentBalance
     * @tim
     */
    public function testGetPaymentBalanceMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('integration test shop');
        $shop = $this->shopTransport->add($newShop);

        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCard());
        $card = $this->cardTransport->activate($card);

        // накидываем транзакций на счёт
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));

        $paymentBalance = $this->cardTransport->getPaymentBalance($shop->getShopId(), $card);
        $this->assertEquals($paymentBalance->getPaymentBalance()->getAmount(), $paymentBalance->getAvailableBalance()->getAmount());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getPaymentBalance
     * @tim
     */
    public function testGetPaymentBalanceWithProductsMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('integration test shop');
        $shop = $this->shopTransport->add($newShop);

        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCard());
        $card = $this->cardTransport->activate($card);

        $chequeRowCollection = \DemoDataGenerator::createChequeRows(rand(2, 10), \TestEnvironmentManager::getDefaultCurrency());

        $paymentBalance = $this->cardTransport->getPaymentBalance($shop->getShopId(), $card, $chequeRowCollection);
        $this::assertEquals(0, $paymentBalance->getAvailableBalance()->getAmount());
        $this::assertEquals(0, $paymentBalance->getPaymentBalance()->getAmount());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::list()
     */
    public function testListMethod(): void
    {
        $newCardCount = 10;
        $paginationResponse = $this->cardTransport->list(new Pagination(3, 1));
        $totalCardCount = $paginationResponse->getPagination()->getResultItemsCount();

        $newCardCollection = \DemoDataGenerator::createNewCardCollection($newCardCount);
        foreach ($newCardCollection as $newCard) {
            $this->cardTransport->addNewCard($newCard);
        }
        $paginationResponse = $this->cardTransport->list(new Pagination());
        $this::assertEquals($totalCardCount + $newCardCount, $paginationResponse->getPagination()->getResultItemsCount());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByBarcode()
     */
    public function testAddNewCardMethod(): void
    {
        $newCard = \DemoDataGenerator::createNewCard();
        $card = $this->cardTransport->addNewCard($newCard);

        $card = $this->cardTransport->getByBarcode($card->getBarcode());

        $this::assertEquals($newCard->getCode(), $card->getCode());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByBarcode()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getAccountStatement()
     */
    public function testAddNewCardWithInitialBalanceWithPennyMethod(): void
    {
        $newCard = \DemoDataGenerator::createNewCard();
        $initialBalance = new Money(1234567, \TestEnvironmentManager::getDefaultCurrency());

        $card = $this->cardTransport->addNewCard($newCard, $initialBalance);
        $activatedCard = $this->cardTransport->activate($card);

        $accountStatement = $this->cardTransport->getAccountStatement($activatedCard);
        // карта создана
        $this::assertEquals($newCard->getCode(), $card->getCode());
        // баланс по карте установлен
        $this::assertEquals($initialBalance->getAmount(), $accountStatement->getBalance()->getAvailable()->getAmount());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::setAccumulationAmount()
     * @throws ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testSetAccumulationAmountWithPennyMethod(): void
    {
        $newCard = \DemoDataGenerator::createNewCard();
        $accumulationAmount = new Money(1234567, \TestEnvironmentManager::getDefaultCurrency());

        $card = $this->cardTransport->addNewCard($newCard);
        $activatedCard = $this->cardTransport->activate($card);

        // устанавливаем на ней нужную сумму накоплений по транзакциям
        $this->cardTransport->setAccumulationAmount($activatedCard, $accumulationAmount);

        $updatedCard = $this->cardTransport->getByCardId($activatedCard->getCardId());

        $this::assertEquals($accumulationAmount->getAmount(), $updatedCard->getAccumSaleAmount()->getAmount());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::setAccumulationAmount()
     * @throws ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testSetAccumulationAmountWithoutPennyMethod(): void
    {
        $newCard = \DemoDataGenerator::createNewCard();
        $accumulationAmount = new Money(1234500, \TestEnvironmentManager::getDefaultCurrency());

        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);

        // устанавливаем на ней нужную сумму накоплений по транзакциям
        $this->cardTransport->setAccumulationAmount($card, $accumulationAmount);

        $updatedCard = $this->cardTransport->getByCardId($card->getCardId());

        $this::assertEquals($accumulationAmount->getAmount(), $updatedCard->getAccumSaleAmount()->getAmount());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByBarcode()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getAccountStatement()
     */
    public function testAddNewCardWithInitialBalanceWithoutPennyMethod(): void
    {
        $newCard = \DemoDataGenerator::createNewCard();
        $initialBalance = new Money(1234500, \TestEnvironmentManager::getDefaultCurrency());

        $card = $this->cardTransport->addNewCard($newCard, $initialBalance);
        $this->cardTransport->activate($card);

        $accountStatement = $this->cardTransport->getAccountStatement($card);
        // карта создана
        $this::assertEquals($newCard->getCode(), $card->getCode());
        // баланс по карте установлен
        $this::assertEquals($initialBalance->getAmount(), $accountStatement->getBalance()->getAvailable()->getAmount());
    }


    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByUser()
     */
    public function testGetByUserMethod(): void
    {
        $user = $this->userTransport->addNewUser(\DemoDataGenerator::createNewUser());
        $attachedCards = $this->cardTransport->getByUser($user);
        $attachedCardsCount = $attachedCards->count();
        $newCardsCount = 1;
        // добавляем ещё карт
        $newCards = \DemoDataGenerator::createNewCardCollection($newCardsCount);

        foreach ($newCards as $newCard) {
            $card = $this->cardTransport->addNewCard($newCard);
            $this->cardTransport->attachToUser($card, $user);
        }
        $attachedCards = $this->cardTransport->getByUser($user);
        $totalCardsCount = $attachedCards->count();

        $this::assertEquals($totalCardsCount, $attachedCardsCount + $newCardsCount);
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getCardLevelList
     * @throws ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testGetCardLevelListMethod(): void
    {
        $cardLevels = $this->cardTransport->getCardLevelList();

        $this::assertGreaterThan(-1, $cardLevels->count());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::levelUp()
     */
    public function testCanLevelUpWithFailureResultMethod(): void
    {
        // получаем список уровней карт
        $cardLevels = $this->cardTransport->getCardLevelList();
        $this::assertGreaterThan(2, $cardLevels->count(), 'для корректной работы теста должно быть минимум два уровня карт');

        // создаём карту с дефолтным уровнем
        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCardWithCardLevel($cardLevels->getFirstLevel()->getLevelId()));
        // активируем её
        $activatedCard = $this->cardTransport->activate($card);

        //пробуем апгрейдить её уровень и это будет неудачно, т.к. накоплений по карте нет
        $levelUpResult = $this->cardTransport->levelUp($activatedCard);
        $this::assertInstanceOf(Cards\DTO\Level\LevelDescription::class, $levelUpResult);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByCardId()
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::levelUp()
     */
    public function testCanLevelUpWithSuccessfulResultMethod(): void
    {
        // получаем список уровней карт
        $cardLevels = $this->cardTransport->getCardLevelList();
        $this::assertGreaterThan(2, $cardLevels->count(), 'для корректной работы теста должно быть минимум два уровня карт');
        // создаём карту с дефолтным начальным уровнем
        $newCard = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCardWithCardLevel($cardLevels->getFirstLevel()->getLevelId()));
        // активируем её
        $card = $this->cardTransport->activate($newCard);
        // обновляем в ней сумму накоплений на превосходящую (>=) желаемый уровень
        $card->setAccumSaleAmount(new Money(1500000000, \TestEnvironmentManager::getDefaultCurrency()));
        $card = $this->cardTransport->update($card);
        //пробуем апгрейдить её уровень
        $levelUpResult = $this->cardTransport->levelUp($card);
        // если всё ок, то функция вернёт null
        $this::assertNull($levelUpResult);
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::getByFilter()
     */
    public function testGetByFilter(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card',
            (string)random_int(1000000, 100000000),
            \TestEnvironmentManager::getDefaultCurrency()
        );
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
            \TestEnvironmentManager::getDefaultCurrency()
        );
        $card = $this->cardTransport->addNewCard($newCard);

        $filteredCard = $this->cardTransport->getByBarcode($card->getBarcode());

        $this->assertEquals($card->getBarcode()->getCode(), $filteredCard->getBarcode()->getCode());
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Role\Organization\Transport::attachToUser()
     */
    public function testAttachToUser(): void
    {
        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCard());

        $user = $this->userTransport->addNewUser(\DemoDataGenerator::createNewUser());

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
        $this->shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->transactionTransport = \Rarus\BonusServer\Transactions\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
