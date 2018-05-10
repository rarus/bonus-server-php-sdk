<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Transport;

use \Rarus\BonusServer\Shops;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Shops\Transport
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
    private $shopTransport;

    /**
     * @covers \Rarus\BonusServer\Shops\Transport\Transport::list()
     */
    public function testListMethod(): void
    {
        $shopCollection = $this->shopTransport->list();
    }

    /**
     * @covers \Rarus\BonusServer\Shops\Transport\Transport::add()
     */
    public function testAddMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('integration test shop');
        $this->shopTransport->add($newShop);
    }

    public function testUpdateMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('new-integration-test-shop');

        $shop = $this->shopTransport->add($newShop);

        $shop->setName('new-integration-test-shop-name');

        $updatedShop = $this->shopTransport->update($shop);

        $this->assertEquals('new-integration-test-shop-name', $updatedShop->getName());
    }

    /**
     * @covers \Rarus\BonusServer\Shops\Transport\Transport::delete()
     */
    public function testDeleteMethod(): void
    {
        $newShop = Shops\DTO\Fabric::createNewInstance('integration test shop for delete');
        $shop = $this->shopTransport->add($newShop);
        $this->shopTransport->delete($shop);
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->shopTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}