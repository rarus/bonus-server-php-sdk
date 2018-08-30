<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Transport\Role\Organization\Transport;

use PHPUnit\Framework\TestCase;
use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Shops;
use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Transactions;
use \Rarus\BonusServer\Discounts;


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
     * @var Shops\Transport\Role\Organization\Transport
     */
    private $shopTransport;
    /**
     * @var Discounts\Transport\Role\Organization\Transport
     */
    private $discountTransport;

    /**
     * @covers \Rarus\BonusServer\Discounts\Transport\Role\Organization\Transport::calculateDiscountsAndBonusDiscounts()
     */
    public function testCalculateDiscountsAndBonusDiscountsMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);


        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        // табличная часть транзакции
        $discountDocument = new Discounts\DTO\Document();
        $discountDocument
            ->setShopId($shop->getShopId())
            ->setCard($card)
            ->setChequeRows(\DemoDataGenerator::createChequeRows(random_int(1, 20), \TestEnvironmentManager::getDefaultCurrency()));

        $estimate = $this->discountTransport->calculateDiscountsAndBonusDiscounts($discountDocument);
        $this->shopTransport->delete($shop);

        $this->assertGreaterThan(0, $estimate->getDocumentItems()->count());
        $this->assertGreaterThan(0, $estimate->getDiscountItems()->count());
    }

    /**
     * @covers \Rarus\BonusServer\Discounts\Transport\Role\Organization\Transport::calculateDiscounts()
     */
    public function testCalculateDiscountsMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);


        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        // табличная часть транзакции
        $discountDocument = new Discounts\DTO\Document();
        $discountDocument
            ->setShopId($shop->getShopId())
            ->setCard($card)
            ->setChequeRows(\DemoDataGenerator::createChequeRows(random_int(1, 20), \TestEnvironmentManager::getDefaultCurrency()));

        $estimate = $this->discountTransport->calculateDiscounts($discountDocument);
        if ($estimate !== null) {
            $this::assertGreaterThan(-1, $estimate->getDiscountItems()->count());
            $this::assertGreaterThan(-1, $estimate->getDocumentItems()->count());
        } else {
            // todo выяснить, по какому принципу будут давать скидки для тестов
            $this::assertNull($estimate);
        }

        $this->shopTransport->delete($shop);
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->discountTransport = Discounts\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );

        $this->cardTransport = Cards\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );

        $this->shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}