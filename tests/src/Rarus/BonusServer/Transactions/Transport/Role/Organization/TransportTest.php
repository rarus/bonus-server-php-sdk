<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport;

use Money\Money;
use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Shops;
use Rarus\BonusServer\Transport\DTO\Pagination;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Transactions;
use PHPUnit\Framework\TestCase;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Cards\Transport
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
     * @var Shops\Transport\Role\Organization\Transport
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

        $historyCollection = $this->transactionTransport->getSalesHistoryByCard($card);
        $this->assertGreaterThan(0, $historyCollection->count());

        $this->shopTransport->delete($shop);
        $this->cardTransport->delete($card, true);
    }

    /**
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::getSalesHistoryByCard()
     */
    public function testGetSalesHistoryByCardForNewCard(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);

        $historyCollection = $this->transactionTransport->getSalesHistoryByCard($card);
        $this::assertEquals(0, $historyCollection->count());

        $this->cardTransport->delete($card, true);
    }

    /**
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::addSaleTransaction()
     */
    public function testGetTransactionsByCard(): void
    {
        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCard());
        $card = $this->cardTransport->activate($card);

        $shop = $this->shopTransport->add(\DemoDataGenerator::createNewShop());

        // конструируем транзакцию
        $saleTransaction = \DemoDataGenerator::createNewSaleTransaction($card, $shop, \TestEnvironmentManager::getDefaultCurrency());
        $finalScore = $this->transactionTransport->addSaleTransaction($saleTransaction);

        // сумма накоплений по карте совпадает с результатами добавления продажи
        // срабатывание process/bonus с начислением баллов не проверям, т.к. програмно его не можем смоделировать - mors
        $cardWithTransaction = $this->cardTransport->getByBarcode($card->getBarcode());
        $this::assertEquals($cardWithTransaction->getAccumSaleAmount()->getAmount(), (int)$finalScore->getCardAccumulationAmount()->getAmount());
    }

    /**
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::getTransactionsByCard()
     */
    public function testGetTransactionsByCardWithInitialBalanceMethod(): void
    {
        $initialBalance = new Money(12345600, \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCard(), $initialBalance);
        $card = $this->cardTransport->activate($card);

        // получаем транзакции по карте
        $transactions = $this->transactionTransport->getTransactionsByCard($card);

        // по только что созданной карте должна быть только одна транзакция начисления баланса
        $this::assertEquals(1, $transactions->getTransactionCollection()->count());
        foreach ($transactions->getTransactionCollection() as $trx) {
            // транзакция должна принадлежать карте
            $this::assertEquals($card->getCardId()->getId(), $trx->getCardId()->getId());
            // сумма по ней должна совпадать с начальным балансом
            $this::assertEquals($initialBalance->getAmount(), $trx->getSum()->getAmount());
            // тип транзакции - внесение
            $this::assertEquals('refund', $trx->getType()->getCode());
        }
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testGetTransactionsByCardWithPaginationPageSizeAndPageNumber(): void
    {
        $pageSize = 2;
        $pageNumber = 1;
        $initialBalance = new Money(12345600, \TestEnvironmentManager::getDefaultCurrency());
        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCard(), $initialBalance);
        $card = $this->cardTransport->activate($card);

        $paginationResponse = $this->transactionTransport->getTransactionsByCard($card, null, null, new Pagination($pageSize, $pageNumber));

        $this::assertEquals($pageSize, $paginationResponse->getPagination()->getPageSize());
        $this::assertEquals($pageNumber, $paginationResponse->getPagination()->getPageNumber());
        $this::assertEquals(1, $paginationResponse->getTransactionCollection()->count());
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

        $this->assertEquals(0, $finalScore->getCardAccumulationAmount()->getAmount());

        $this->shopTransport->delete($shop);
        $this->cardTransport->delete($card, true);
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
        $this->shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance(
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