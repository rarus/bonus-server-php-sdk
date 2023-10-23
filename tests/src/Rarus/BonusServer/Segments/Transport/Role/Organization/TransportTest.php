<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Tests\Segments\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Segments\DTO\Segment;
use Rarus\BonusServer\Segments\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class TransportTest
 *
 * @package src\Rarus\BonusServer\Segments\Transport\Role\Organization
 */
class TransportTest extends TestCase
{
    /**
     * @var \Rarus\BonusServer\Segments\Transport\Role\Organization\Transport
     */
    private $segmentTransport;
    /**
     * @var \Rarus\BonusServer\Users\Transport\Role\Organization\Transport
     */
    private $userTransport;
    /**
     * @var \Rarus\BonusServer\Shops\Transport\Role\Organization\Transport
     */
    private $shopTransport;
    /**
     * @var \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport
     */
    private $transactionTransport;

    public function testAddNewSegment(): void
    {
        $newSegment = (new Segment())
        ->setName('Тестовый сегмент')
        ->setMaxPaymentPercent(10);

        $segment = $this->segmentTransport->addNewSegment($newSegment);

        $this->assertEquals($newSegment->getName(), $segment->getName());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testUpdateMethod(): void
    {
        $newSegment = (new Segment())
            ->setName('Тестовый сегмент')
            ->setMaxPaymentPercent(10);

        $segment = $this->segmentTransport->addNewSegment($newSegment);

        $updateSegment = $segment->setName('Тестовый сегмент 2');
        $updatedSegment = $this->segmentTransport->update($updateSegment);

        $this->assertEquals($updateSegment->getName(), $updatedSegment->getName());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testDeleteMethod(): void
    {
        $newSegment = (new Segment())
            ->setName('Тестовый сегмент')
            ->setMaxPaymentPercent(10);

        $segment = $this->segmentTransport->addNewSegment($newSegment);

        $this->segmentTransport->delete($segment);

        $deletedSegment = null;
        try {
            $deletedSegment = $this->segmentTransport->getBySegmentId($segment->getSegmentId());
        } catch (NetworkException $e) {
        } catch (ApiClientException $e) {
        } catch (UnknownException $e) {
        }

        $this->assertNull($deletedSegment);
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testListMethod(): void
    {
        $newSegment = (new Segment())
            ->setName('Тестовый сегмент')
            ->setMaxPaymentPercent(10);
        $this->segmentTransport->addNewSegment($newSegment);
        $this->segmentTransport->addNewSegment($newSegment);

        $segmentCollection = $this->segmentTransport->list(new Pagination());

        $this->assertGreaterThanOrEqual(2, $segmentCollection->getPagination()->getResultItemsCount());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->segmentTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->userTransport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->shopTransport = \Rarus\BonusServer\Shops\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->transactionTransport = \Rarus\BonusServer\Transactions\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
