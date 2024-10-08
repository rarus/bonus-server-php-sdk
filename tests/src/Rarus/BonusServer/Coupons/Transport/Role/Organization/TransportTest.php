<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Tests\Coupons\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Coupons\DTO\CouponGroupFilter;
use Rarus\BonusServer\Coupons\DTO\CouponGroupId;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Coupons\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;

use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class TransportTest
 *
 * @package src\Rarus\BonusServer\Segments\Transport\Role\Organization
 */
class TransportTest extends TestCase
{
    /**
     * @var \Rarus\BonusServer\Coupons\Transport\Role\Organization\Transport
     */
    private $couponTransport;


    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testGetByCouponId(): void
    {
        $couponId = new CouponId('123');
        $coupon = $this->couponTransport->getByCouponId($couponId);
        $this->assertEquals($couponId, $coupon->getId());
    }

    public function testGetCouponGroupById(): void
    {
        $couponGroupId = new CouponGroupId('70456625-9304-4ac6-b9f9-aa8ff0a31c31');
        $couponGroup = $this->couponTransport->getGroupById($couponGroupId);
        $this->assertEquals($couponGroup->getId()->getId(), $couponGroupId->getId());
    }

    public function testGroupCollectionByFilter(): void
    {
        $filter = new CouponGroupFilter();
        $filter->setType(1);
        $pagination = new Pagination();
        $couponGroupCollection = $this->couponTransport->getGroupCollectionByFilter($filter, $pagination);
        $this->assertGreaterThan(-1, $couponGroupCollection->getCouponGroupCollection()->count());
    }



    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->couponTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
