<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\Transport\Role\Organization;


use Fig\Http\Message\RequestMethodInterface;
use Money\Money;
use Rarus\BonusServer\Certificates\DTO\Certificate;
use Rarus\BonusServer\Certificates\DTO\CertificateGroup;
use Rarus\BonusServer\Certificates\DTO\CertificateGroupCollection;
use Rarus\BonusServer\Certificates\DTO\CertificateGroupId;
use Rarus\BonusServer\Certificates\DTO\CertificateId;
use Rarus\BonusServer\Certificates\DTO\Fabric;
use Rarus\BonusServer\Certificates\Transport\DTO\CertificateGroupPaginationResponse;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection;
use Rarus\BonusServer\Transport\AbstractTransport;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Certificates\Transport\Role\Organization
 */
class Transport extends AbstractTransport
{
    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function add(Certificate $newCertificate): Certificate
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.add.start',
            [
                'certificateId' => $newCertificate->getCertificateId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/certificate/add',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Certificates\Formatters\Certificate::toArrayForCreateNewCertificate($newCertificate)
        );

        $certificate = $this->getByCertificateId(new CertificateId($requestResult['id']));

        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.add.add.finish',
            [
                'id' => $certificate->getCertificateId()->getId(),
            ]
        );

        return $certificate;
    }

    /**
     * @param CertificateId $certificateId
     *
     * @return Certificate
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function getByCertificateId(CertificateId $certificateId): Certificate
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.getByCertificateId.start',
            [
                'certificateId' => $certificateId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/certificate/%s?full_info=%s', $certificateId->getId(), 'True'),
            RequestMethodInterface::METHOD_GET
        );

        $certificate = Fabric::initCertificateFromServerResponse(
            $this->getDefaultCurrency(),
            $requestResult['certificate']
        );

        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.getByCertificateId.end',
            [
                'certificateId' => $certificate->getCertificateId()->getId(),
            ]
        );

        return $certificate;
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\CertificateId $certificateId
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function delete(CertificateId $certificateId): void
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.add.start',
            [
                'certificateId' => $certificateId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/certificate/%s/delete', $certificateId->getId()),
            RequestMethodInterface::METHOD_POST
        );
    }

    /**
     * @param string                                                                 $docId
     * @param \Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection $certPaymentCollection
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function pay(string $docId, CertPaymentCollection $certPaymentCollection): void
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.pay.start',
            [
                'doc_id' => $docId,
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/certificate/pay',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Certificates\Formatters\Certificate::toArrayForPay($docId, $certPaymentCollection)
        );
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\CertificateId $certificateId
     * @param \Money\Money|null                                 $sum
     * @param string|null                                       $docId
     *
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function activate(CertificateId $certificateId, ?Money $sum, ?string $docId): void
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.activate.start',
            [
                'certificateId' => $certificateId->getId(),
                'doc_id'        => $docId,
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/certificate/activate',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Certificates\Formatters\Certificate::toArrayForActivate($certificateId, $sum, $docId)
        );
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     */
    public function groupAdd(CertificateGroup $newCertificateGroup): CertificateGroup
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.groupAdd.start',
            [
                'certificateGroupId' => $newCertificateGroup->getCertificateGroupId()->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/certificate_group/add',
            RequestMethodInterface::METHOD_POST,
            \Rarus\BonusServer\Certificates\Formatters\CertificateGroup::toArrayForCreateNewCertificateGroup($newCertificateGroup)
        );

        $certificateGroup = $this->getGroupCertificateById(new CertificateGroupId($requestResult['id']));

        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.groupAdd.finish',
            [
                'id' => $certificateGroup->getCertificateGroupId()->getId(),
            ]
        );

        return $certificateGroup;
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\CertificateGroupId $certificateGroupId
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function getGroupCertificateById(CertificateGroupId $certificateGroupId): CertificateGroup
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.getGroupCertificateById.start',
            [
                'certificateGroupId' => $certificateGroupId->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/certificate_group/%s', $certificateGroupId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $certificateGroup = Fabric::initCertificateGroupFromServerResponse(
            $requestResult['certificate_group']
        );

        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.getGroupCertificateById.end',
            [
                'certificateGroupId' => $certificateGroup->getCertificateGroupId()->getId(),
            ]
        );

        return $certificateGroup;
    }

    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     * @throws \Rarus\BonusServer\Exceptions\NetworkException
     * @throws \Rarus\BonusServer\Exceptions\UnknownException
     */
    public function groupList(Pagination $pagination): CertificateGroupPaginationResponse
    {
        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.groupList.start',
            [
                'pageSize'   => $pagination->getPageSize(),
                'pageNumber' => $pagination->getPageNumber(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                '/organization/certificate_group?calculate_count=true%s',
                \Rarus\BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
            ),
            RequestMethodInterface::METHOD_GET
        );

        $certificateGroupCollection = new CertificateGroupCollection();
        foreach ((array)$requestResult['certificate_groups'] as $certificate_group) {
            $certificateGroupCollection->attach(Fabric::initCertificateGroupFromServerResponse($certificate_group));
        }

        $paginationResponse = new CertificateGroupPaginationResponse(
            $certificateGroupCollection,
            \Rarus\BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse(
                (array)$requestResult['pagination']
            )
        );

        $this->log->debug(
            'rarus.bonus.server.certificates.transport.organization.groupList.finish',
            [
                'itemsCount' => $certificateGroupCollection->count(),
            ]
        );

        return $paginationResponse;
    }
}
