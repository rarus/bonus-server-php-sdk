<?php

namespace Rarus\BonusServer\Tests\Holds\Transport\Role\Organization;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Holds\DTO\HoldId;
use Rarus\BonusServer\Holds\DTO\NewHold;
use Rarus\BonusServer\Holds\Transport\Role\Organization\Transport;
use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Holds\DTO\HoldFilter;
use Rarus\BonusServer\Holds\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Transport\DTO\Pagination;
use TestEnvironmentManager;

class TransportTest extends TestCase
{
    /**
     * @var Transport
     */
    private $holdTransport;

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testList()
    {
        $holdFilter = new HoldFilter();
        $holdFilter->setStartDateFrom(new \DateTime());
        $holds = $this->holdTransport->list($holdFilter, new Pagination());
        $this->assertGreaterThan(-1, $holds->getHoldCollection()->count());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testGetById()
    {
        $holdFilter = new HoldFilter();
        $holdFilter->setStartDateFrom(new \DateTime());
        $holds = $this->holdTransport->list($holdFilter, new Pagination());
        $hold = $holds->getHoldCollection()->current();
        $holdById = $this->holdTransport->getById($hold->getHoldId());

        $this->assertEquals($hold, $holdById);
    }

    /**
     * @throws ApiClientException
     * @throws UnknownException
     * @throws NetworkException
     */
    public function testAdd()
    {
        $newHold = new NewHold(
            new HoldId(),
            new CardId('f627034f-9748-41a6-9fd3-46ce14a5fffb'),
            0.1,
            'Заморозка тест',
            (new \DateTime())->modify('+1 month')
        );

        $holdId = $this->holdTransport->add($newHold);

        $this->assertNotEmpty($holdId);
    }

    /**
     * @throws NetworkException
     * @throws ApiClientException
     * @throws UnknownException
     */
    public function testDelete()
    {
        $holdFilter = new HoldFilter();
        $holdFilter->setStartDateFrom(new \DateTime());
        $holds = $this->holdTransport->list($holdFilter, new Pagination());
        $hold = $holds->getHoldCollection()->current();

        $this->holdTransport->delete($hold->getHoldId());
        $holdsAfterDelete = $this->holdTransport->list($holdFilter, new Pagination());

        $this->assertEquals($holds->getHoldCollection()->count() - 1, $holdsAfterDelete->getHoldCollection()->count());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->holdTransport = Fabric::getInstance(
            TestEnvironmentManager::getInstanceForRoleOrganization(),
            TestEnvironmentManager::getDefaultCurrency(),
            TestEnvironmentManager::getMonologInstance()
        );
    }
}
