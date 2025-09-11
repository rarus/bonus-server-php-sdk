<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Holds\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusDto;
use Rarus\LMS\SDK\Transport\BaseTransport;

final class HoldTransport extends BaseTransport
{
    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function createHoldBonus(HoldBonusDto $holdBonusDto): int
    {
        $holdId = $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/hold-bonus',
            $holdBonusDto->toArray()
        );

        return (int) $holdId;
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getHoldBonus(int $holdId): HoldBonusDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/hold-bonus/%s', $holdId),
        );

        return HoldBonusDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function deleteHoldBonus(int $holdId): void
    {
        $this->transport->request(
            RequestMethodInterface::METHOD_DELETE,
            sprintf('web-flow/hold-bonus/%s', $holdId),
        );
    }
}
