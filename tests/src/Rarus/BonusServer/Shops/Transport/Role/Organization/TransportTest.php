<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Shops;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Shops\Transport
 */
class TransportTest extends TestCase
{
    /**
     * @var Transport
     */
    private $shopTransport;

    /**
     * @covers \Rarus\BonusServer\Shops\Transport\Role\Organization\Transport::list()
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testListMethod(): void
    {
        $shopCollectionBefore = $this->shopTransport->list();
        $newShop = Shops\DTO\Fabric::createNewInstance('integration test shop');
        $this->shopTransport->add($newShop);
        $shopCollectionAfter = $this->shopTransport->list();

        $this->assertGreaterThan($shopCollectionBefore->count(), $shopCollectionAfter->count());
    }

    /**
     * @covers \Rarus\BonusServer\Shops\Transport\Role\Organization\Transport::add()
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testAddMethod(): void
    {
        $newShopName = 'integration test shop';
        $newShop = Shops\DTO\Fabric::createNewInstance($newShopName);
        $newShop = $this->shopTransport->add($newShop);
        $this->assertEquals($newShopName, $newShop->getName());
    }

    /**
     * @covers \Rarus\BonusServer\Shops\Transport\Role\Organization\Transport::update()
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testUpdateMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('new-integration-test-shop');

        $shop = $this->shopTransport->add($newShop);

        $shop->setName('new-integration-test-shop-name');

        $updatedShop = $this->shopTransport->update($shop);

        $this->assertEquals('new-integration-test-shop-name', $updatedShop->getName());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testUpdateScheduleMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('new-integration-test-shop');
        $shop = $this->shopTransport->add($newShop);

        $scheduleCollection = new Shops\DTO\ScheduleCollection();
        $schedule = (new Shops\DTO\Schedule())
            ->setDayStart(1)
            ->setDayEnd(7)
            ->setTimeStart(123234)
            ->setTimeEnd(323234)
            ->setIsOpen(true)
        ;
        $scheduleCollection->attach($schedule);
        $shop->setSchedule($scheduleCollection);

        $updatedShop = $this->shopTransport->update($shop);

        $this->assertGreaterThan(0, $updatedShop->getSchedule()->count());
    }

    /**
     * @covers \Rarus\BonusServer\Shops\Transport\Role\Organization\Transport::delete()
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testDeleteMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('integration test shop for delete');
        $shop = $this->shopTransport->add($newShop);
        $this->shopTransport->delete($shop);

        $this->assertEquals(false, $this->shopTransport->isShopExistsWithId($shop->getShopId()));
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->shopTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
