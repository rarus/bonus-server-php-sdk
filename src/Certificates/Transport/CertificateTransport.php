<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Certificates\DTO\CertificateDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Transport\BaseTransport;

final class CertificateTransport extends BaseTransport
{
    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getCertificateById(string $id): CertificateDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/certificate/%s', $id),
        );

        return CertificateDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @throws UnknownException
     * @throws ApiClientException
     * @throws NetworkException
     */
    public function createCertificate(string $code, int $parentId, ?bool $deleted = false): string
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/certificate',
            [
                'code' => $code,
                'parent_id' => $parentId,
                'deleted' => $deleted,
            ],
        );

        return (string)$result;
    }
}
