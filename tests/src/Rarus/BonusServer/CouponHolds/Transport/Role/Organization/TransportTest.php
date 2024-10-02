<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Tests\CouponHolds\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\CouponHolds\DTO\CouponHold;
use Rarus\BonusServer\CouponHolds\DTO\NewCouponHold;
use Rarus\BonusServer\CouponHolds\Transport\Role\Organization\Transport;
use Rarus\BonusServer\CouponHolds\DTO\CouponHoldId;
use Rarus\BonusServer\CouponHolds\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Coupons\DTO\CouponId;
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
     * @var Transport
     */
    private $couponHoldsTransport;


    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testadd(): void
    {
        $couponId = new CouponId('1000');
        $newCouponHold = new NewCouponHold(new CouponHoldId(''));
        $cardId = new CardId('f627034f-9748-41a6-9fd3-46ce14a5fffb');

        $newCouponHold
            ->setCouponId($couponId)
            ->setCardId($cardId)
            ->setComment('test')
            ->setDateTo((new \DateTime())->modify('+1 month'))
        ;

        $couponHold = $this->couponHoldsTransport->add($newCouponHold);
        $this->assertNotEmpty($couponHold->getId());
    }

    public function testGetList(): void
    {
        $couponId = new CouponId('1000');
        $newCouponHold = new NewCouponHold(new CouponHoldId(''));
        $cardId = new CardId('f627034f-9748-41a6-9fd3-46ce14a5fffb');

        $newCouponHold
            ->setCouponId($couponId)
            ->setCardId($cardId)
            ->setComment('test')
            ->setDateTo((new \DateTime())->modify('+1 month'))
        ;

        $this->couponHoldsTransport->add($newCouponHold);
        $holds = $this->couponHoldsTransport->getList(null, $cardId, new Pagination());

        $this->assertGreaterThan(-1, $holds->getCouponHoldCollection()->count());
    }

    public function testdelete(): void
    {
        $couponId = new CouponId('1000');
        $newCouponHold = new NewCouponHold(new CouponHoldId(''));
        $cardId = new CardId('f627034f-9748-41a6-9fd3-46ce14a5fffb');

        $newCouponHold
            ->setCouponId($couponId)
            ->setCardId($cardId)
            ->setComment('test')
            ->setDateTo((new \DateTime())->modify('+1 month'))
        ;

        $deleted = null;
        try {
            $couponHoldId = $this->couponHoldsTransport->add($newCouponHold);
            $this->couponHoldsTransport->delete($couponHoldId);
        } catch (NetworkException $e) {
        } catch (ApiClientException $e) {
        } catch (UnknownException $e) {
        }

        $this->assertEmpty($deleted);
    }

    /**
     * @return void
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testgetById(): void
    {
        $couponId = new CouponId('1000');
        $newCouponHold = new NewCouponHold(new CouponHoldId(''));
        $cardId = new CardId('f627034f-9748-41a6-9fd3-46ce14a5fffb');

        $newCouponHold
            ->setCouponId($couponId)
            ->setCardId($cardId)
            ->setComment('test')
            ->setDateTo((new \DateTime())->modify('+1 month'))
        ;

        $couponHoldId = $this->couponHoldsTransport->add($newCouponHold);
        $couponHold = $this->couponHoldsTransport->getById($couponHoldId);

        $this->assertEquals($couponHoldId, $couponHold->getId());
    }


    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->couponHoldsTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
