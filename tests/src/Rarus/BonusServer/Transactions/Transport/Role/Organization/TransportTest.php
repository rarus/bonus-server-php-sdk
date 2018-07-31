<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport;

use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Shops;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Transactions;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Cards\Transport
 */
class TransportTest extends \PHPUnit_Framework_TestCase
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
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::getSalesHistoryByCard()
     */
    public function testGetSalesHistoryByCard(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);

        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        // конструируем транзакцию
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));

        $this->transactionTransport->getSalesHistoryByCard($card);
    }

    /**
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::addSaleTransaction()
     */
    public function testGetTransactionsByCard(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);

        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        // конструируем транзакцию
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));

        $transactionCollection = $this->transactionTransport->getTransactionsByCard($card);
    }

    /**
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::addSaleTransaction()
     */
    public function testAddSaleTransactionMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);

        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        $this->transactionTransport->addSaleTransaction(\DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency()));
    }

    /**
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::addRefundTransaction()
     */
    public function testAddRefundTransactionMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);

        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        $authorName = 'Кассир Иванов Иван Иванович';
        $description = 'Продажа по документу Чек№100500';
        $document = Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0);
        $refundDocument = Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0);
        $cashRegister = \Rarus\BonusServer\Transactions\DTO\CashRegister\Fabric::createNewInstance((string)random_int(1000000, 100000000), 'касса 1');
        $chequeNumber = (string)random_int(1000000, 100000000);

        // конструируем транзакцию
        // табличная часть транзакции
        $chequeRowCollection = new Transactions\DTO\ChequeRows\ChequeRowCollection();;
        $chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
            ->setLineNumber(1)
            ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-11111'))
            ->setName('товар 1')
            ->setQuantity(2)
            ->setPrice(new \Money\Money(400, new \Money\Currency('RUB')))
            ->setSum(new \Money\Money(4000, new \Money\Currency('RUB')))
            ->setDiscount(new \Money\Money(40, new \Money\Currency('RUB'))));

        $saleTransaction = new Transactions\DTO\Sale();
        $saleTransaction
            ->setCardId($card->getCardId())
            ->setShopId($shop->getShopId())
            ->setAuthorName($authorName)
            ->setDescription($description)
            ->setDocument($document)
            ->setCashRegister($cashRegister)
            ->setChequeNumber($chequeNumber)
            ->setBonusPayment(0)
            ->setChequeRows($chequeRowCollection);

        $finalScore = $this->transactionTransport->addSaleTransaction($saleTransaction);

        // откатываем транзакцию
        $refundTransaction = new Transactions\DTO\Refund();
        $refundTransaction
            ->setCardId($card->getCardId())
            ->setShopId($shop->getShopId())
            ->setAuthorName($authorName)
            ->setDescription('отмена: ' . $description)
            ->setDocument($document)
            ->setRefundDocument($refundDocument)
            ->setRefundBonus(10)
            ->setCashRegister($cashRegister)
            ->setChequeNumber($chequeNumber)
            ->setChequeRows($chequeRowCollection);

        $finalScore = $this->transactionTransport->addRefundTransaction($refundTransaction);
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