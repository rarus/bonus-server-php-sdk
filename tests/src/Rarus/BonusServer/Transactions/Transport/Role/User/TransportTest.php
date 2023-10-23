<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Tests\Transactions\Transport\Role\User;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Auth;
use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Shops;
use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Users;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Transactions\Transport\Role\User\Transport
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
     * @covers \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport::addSaleTransaction()
     */
    public function testGetSalesHistoryMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $cardWithoutUser = $this->cardTransport->activate($card);

        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        // добавляем пользователя
        $userPassword = sha1('12345');
        $userUid = 'grishi-uid-' . random_int(0, PHP_INT_MAX);
        $newUsersCollection = new Users\DTO\UserCollection();
        $newUsersCollection->attach(\DemoDataGenerator::createNewUserWithUserUidAndPassword($userUid, $userPassword));
        $this->userTransport->importNewUsers($newUsersCollection);

        // привязываем карту к пользователю
        $importedUser = $this->userTransport->getByUserId(new Users\DTO\UserId($userUid));
        $card = $this->cardTransport->attachToUser($cardWithoutUser, $importedUser);

        // конструируем транзакции
        // табличная часть транзакции
        $chequeRowCollection = new Transactions\DTO\ChequeRows\ChequeRowCollection();
        ;
        $chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
            ->setLineNumber(1)
            ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-11111'))
            ->setName('товар 1')
            ->setQuantity(2)
            ->setPrice(new \Money\Money(400, new \Money\Currency('RUB')))
            ->setSum(new \Money\Money(4000, new \Money\Currency('RUB')))
            ->setDiscount(new \Money\Money(40, new \Money\Currency('RUB'))));
        $chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
            ->setLineNumber(2)
            ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-222222'))
            ->setName('товар 1')
            ->setQuantity(2)
            ->setPrice(new \Money\Money(900, new \Money\Currency('RUB')))
            ->setSum(new \Money\Money(9000, new \Money\Currency('RUB')))
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

        $chequeRowCollection = new Transactions\DTO\ChequeRows\ChequeRowCollection();
        $saleTransaction = new Transactions\DTO\Sale();
        $chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
            ->setLineNumber(1)
            ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId('ART-222222'))
            ->setName('товар 1')
            ->setQuantity(2)
            ->setPrice(new \Money\Money(100, new \Money\Currency('RUB')))
            ->setSum(new \Money\Money(1000, new \Money\Currency('RUB')))
            ->setDiscount(new \Money\Money(40, new \Money\Currency('RUB'))));
        $saleTransaction
            ->setCardId($card->getCardId())
            ->setShopId($shop->getShopId())
            ->setAuthorName('Кассир Иванов')
            ->setDescription('Продажа по документу Чек№100501')
            ->setDocument(Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0))
            ->setCashRegister(\Rarus\BonusServer\Transactions\DTO\CashRegister\Fabric::createNewInstance((string)random_int(1000000, 100000000), 'касса 1'))
            ->setChequeNumber((string)random_int(1000000, 100000000))
            ->setBonusPayment(0)
            ->setChequeRows($chequeRowCollection);

        $finalScore = $this->transactionTransport->addSaleTransaction($saleTransaction);

        // авторизуемся на бонусном сервере под учётной записью пользователя
        $companyId = \TestEnvironmentManager::getInstanceForRoleOrganization()->getAuthToken()->getCompanyId();
        $userCredentials = Auth\Fabric::createCredentialsForRoleClient($companyId, $userUid, $userPassword);
        $apiClient = \TestEnvironmentManager::getInstanceForRoleOrganization();
        $userAuthToken = $apiClient->getNewAuthToken($userCredentials);
        $apiClient->setAuthToken($userAuthToken);

        $cardsUserRoleTransport = Cards\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), \TestEnvironmentManager::getMonologInstance());
        $transactionsRoleUser = Transactions\Transport\Role\User\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), \TestEnvironmentManager::getMonologInstance());

        $cards = $cardsUserRoleTransport->list();
        foreach ($cards as $card) {
            $history = $transactionsRoleUser->getSalesHistory($card);
            // количество транзакций по карте
            $this->assertEquals($history->count(), 2);
        }

        $this->shopTransport->delete($shop);
        $this->cardTransport->delete($card);
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
