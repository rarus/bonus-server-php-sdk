<?php

namespace src\Rarus\BonusServer\Certificates\Transport\Role\Organization;

use Money\Money;
use Rarus\BonusServer\Certificates\DTO\Certificate;
use Rarus\BonusServer\Certificates\DTO\CertificateGroup;
use Rarus\BonusServer\Certificates\DTO\CertificateGroupId;
use Rarus\BonusServer\Certificates\DTO\CertificateId;
use Rarus\BonusServer\Certificates\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Certificates\Transport\Role\Organization\Transport;
use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPayment;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Util\MoneyParser;

class TransportTest extends TestCase
{

    /**
     * @var Transport
     */
    private $certificateTransport;

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testAdd(): void
    {
        $certificateGroup = new CertificateGroup();
        $certificateGroup->setId(new CertificateGroupId('dc9699d4-86da-4ceb-bdbe-9d2b9d80e91d'));

        $certificateId = uniqid('', true);
        $newCertificate = new Certificate(
            new CertificateId($certificateId)
        );
        $newCertificate->setCertificateGroup($certificateGroup);

        $certificate = $this->certificateTransport->add($newCertificate);

        $this->assertEquals($certificateId, $certificate->getCertificateId()->getId());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function testDelete(): void
    {
        $certificate = $this->createNewCertificate();
        $this->certificateTransport->delete($certificate->getCertificateId());
        $deletedCertificate = $this->certificateTransport->getByCertificateId($certificate->getCertificateId());
        $this->assertEquals(3, $deletedCertificate->getStatus());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testActivate(): void
    {
        $certificate = $this->createNewCertificate();
        $sum = MoneyParser::parseFloat(1320, \TestEnvironmentManager::getDefaultCurrency());
        $docId = null;
        $this->certificateTransport->activate($certificate->getCertificateId(), $sum, $docId);
        $certificate = $this->certificateTransport->getByCertificateId($certificate->getCertificateId());
        $this->assertEquals(1, $certificate->getStatus());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function testPay(): void
    {
        $certificate = $this->createNewCertificate();
        $certificateId = $certificate->getCertificateId();

        // активация
        $sum = MoneyParser::parseFloat(1000, \TestEnvironmentManager::getDefaultCurrency());
        $docId = null;
        $this->certificateTransport->activate($certificate->getCertificateId(), $sum, $docId);

        $certPaymentCollection = new CertPaymentCollection();
        $certificatePayment = new CertPayment();
        $certificatePayment->setLineNumber(1)->setCertificateId($certificateId)->setSum(new Money(1000, \TestEnvironmentManager::getDefaultCurrency()));
        $certPaymentCollection->attach($certificatePayment);

        $this->certificateTransport->pay('100121', $certPaymentCollection);
        $certificate = $this->certificateTransport->getByCertificateId($certificateId);

        $this->assertEquals(2, $certificate->getStatus());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testGetByCertificateId(): void
    {
        $certificate = $this->createNewCertificate();
        $newCertificateId = $certificate->getCertificateId();
        $certificateId = $this->certificateTransport->getByCertificateId($newCertificateId);
        $this->assertEquals($newCertificateId->getId(), $certificateId->getCertificateId()->getId());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testGroupAdd(): void
    {
        $newCertificateGroup = new CertificateGroup();
        $newCertificateGroup->setId(new CertificateGroupId(uniqid()))->setName('TEST_GROUP_' . mt_rand(100, 1000))->setPeriodType(0);

        $certificateGroup = $this->certificateTransport->groupAdd($newCertificateGroup);

        $this->assertEquals($newCertificateGroup->getCertificateGroupId()->getId(), $certificateGroup->getCertificateGroupId()->getId());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function testGroupById(): void
    {
        $certificateGroupId = new CertificateGroupId('dc9699d4-86da-4ceb-bdbe-9d2b9d80e91d');
        $certificateGroup = $this->certificateTransport->getGroupCertificateById($certificateGroupId);
        $this->assertEquals($certificateGroupId->getId(), $certificateGroup->getCertificateGroupId()->getId());
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function testGroupList(): void
    {
        $certificateGroupCount = 1;
        $paginationResponse = $this->certificateTransport->groupList(new Pagination(3, 1));
        $totalCertificateGroup = $paginationResponse->getPagination()->getResultItemsCount();

        $paginationResponse = $this->certificateTransport->groupList(new Pagination());
        $this::assertLessThanOrEqual($paginationResponse->getPagination()->getResultItemsCount(), $certificateGroupCount);
    }

    /**
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    private function createNewCertificate(): Certificate
    {
        $certificateGroup = new CertificateGroup();
        $certificateGroup->setId(new CertificateGroupId('dc9699d4-86da-4ceb-bdbe-9d2b9d80e91d'));

        $certificateId = uniqid('', true);
        $newCertificate = new Certificate(
            new CertificateId($certificateId)
        );
        $newCertificate->setCertificateGroup($certificateGroup);

        return $this->certificateTransport->add($newCertificate);
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->certificateTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
