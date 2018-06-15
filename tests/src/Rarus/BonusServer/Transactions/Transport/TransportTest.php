<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Transport;

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
     * @var Transactions\Transport\Transport
     */
    private $transactionTransport;

    /**
     * @covers \Rarus\BonusServer\Transactions\Transport\Transport::addSaleTransaction()
     */
    public function testAddSaleTransactionMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);

        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

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
            ->setAuthorName('Кассир Иванов')
            ->setDescription('Продажа по документу Чек№100500')
            ->setDocument(Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0))
            ->setCashRegister(\Rarus\BonusServer\Transactions\DTO\CashRegister\Fabric::createNewInstance((string)random_int(1000000, 100000000), 'касса 1'))
            ->setChequeNumber((string)random_int(1000000, 100000000))
            ->setBonusPayment(0)
            ->setChequeRows($chequeRowCollection);

        $finalScore = $this->transactionTransport->addSaleTransaction($saleTransaction);

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
        $this->transactionTransport = Transactions\Transport\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}