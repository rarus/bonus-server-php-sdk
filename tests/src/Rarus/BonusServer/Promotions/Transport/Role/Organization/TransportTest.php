<?php

namespace src\Rarus\BonusServer\Promotions\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Promotions\DTO\Promotion;
use Rarus\BonusServer\Promotions\DTO\PromotionFilter;
use Rarus\BonusServer\Promotions\DTO\PromotionId;
use Rarus\BonusServer\Promotions\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Transport\DTO\Pagination;

class TransportTest extends TestCase
{
    /**
     * @var \Rarus\BonusServer\Promotions\Transport\Role\Organization\Transport
     */
    private $promotionTransport;

    /**
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Exception
     */
    public function testStoreAndGetByID()
    {
        $promotion = new Promotion(new PromotionId(
            sprintf('id-%d', \random_int(0, PHP_INT_MAX))
        ));
        $promotion
            ->setName('test promotion')
            ->setShortDescription('short description')
            ->setFullDescription('full description');

        $addedPromotion = $this->promotionTransport->store($promotion);

        $this->assertEquals($promotion->getPromotionId()->getId(), $addedPromotion->getPromotionId()->getId());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function testList()
    {
        $promotion = new Promotion(new PromotionId(
            sprintf('id-%d', \random_int(0, PHP_INT_MAX))
        ));
        $promotion
            ->setName('test promotion')
            ->setShortDescription('short description')
            ->setFullDescription('full description');

        $this->promotionTransport->store($promotion);

        $filter = new PromotionFilter();
        $promotionCollection = $this->promotionTransport->list($filter, new Pagination());

        $this->assertGreaterThan(1, $promotionCollection->getPagination()->getResultItemsCount());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function testDelete()
    {
        $promotion = new Promotion(new PromotionId(
            sprintf('id-%d', \random_int(0, PHP_INT_MAX))
        ));
        $promotion
            ->setName('test promotion')
            ->setShortDescription('short description')
            ->setFullDescription('full description');

        $this->promotionTransport->store($promotion);

        $filter = new PromotionFilter();
        $promotionCollection = $this->promotionTransport->list($filter, new Pagination());
        $currentCount = $promotionCollection->getPagination()->getResultItemsCount();

        $this->promotionTransport->delete($promotion->getPromotionId());

        $promotionCollection = $this->promotionTransport->list($filter, new Pagination());
        $afterDeletedCount = $promotionCollection->getPagination()->getResultItemsCount();

        $this->assertLessThan($currentCount, $afterDeletedCount);
    }

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->promotionTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}