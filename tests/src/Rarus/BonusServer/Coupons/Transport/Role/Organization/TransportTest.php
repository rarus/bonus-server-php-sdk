<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Tests\Coupons\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Coupons\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;

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
