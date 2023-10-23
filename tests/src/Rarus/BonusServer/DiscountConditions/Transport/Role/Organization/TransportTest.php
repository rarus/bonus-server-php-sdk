<?php

namespace Rarus\BonusServer\Tests\DiscountConditions\Transport\Role\Organization;

use Exception;
use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\DiscountConditions\DTO\DiscountConditionFilter;
use Rarus\BonusServer\DiscountConditions\Transport\Role\Organization\Transport;
use Rarus\BonusServer\Discounts\DTO\DiscountFilter;
use Rarus\BonusServer\Discounts\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Transport\DTO\Pagination;
use TestEnvironmentManager;

/**
 * @property \Rarus\BonusServer\Discounts\Transport\Role\Organization\Transport $discountTransport
 * @property Transport $discountConditionTransport
 */
class TransportTest extends TestCase
{

    /**
     * @return void
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testGetByFilter()
    {
        $discountFilter = new DiscountFilter();
        $pagination = new Pagination();
        $discounts = $this->discountTransport->getByFilter($discountFilter, $pagination);
        $discountId = $discounts->getDiscountCollection()->current()->getId();

        $discountConditionFilter = new DiscountConditionFilter();
//        $discountConditionFilter->setDiscountId(new DiscountId($discountId));
        $conditions = $this->discountConditionTransport->getByFilter($discountConditionFilter, new Pagination());
        $this->assertGreaterThan(-1, $conditions->getDiscountConditionCollection()->count());
    }

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->discountTransport = Fabric::getInstance(
            TestEnvironmentManager::getInstanceForRoleOrganization(),
            TestEnvironmentManager::getDefaultCurrency(),
            TestEnvironmentManager::getMonologInstance()
        );

        $this->discountConditionTransport = \Rarus\BonusServer\DiscountConditions\Transport\Role\Organization\Fabric::getInstance(
            TestEnvironmentManager::getInstanceForRoleOrganization(),
            TestEnvironmentManager::getDefaultCurrency(),
            TestEnvironmentManager::getMonologInstance()
        );
    }
}
