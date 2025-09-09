<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoСodes\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\PromoСodes\DTO\HoldPromoCodeDto;
use Rarus\LMS\SDK\PromoСodes\DTO\PromoCodeDto;
use Rarus\LMS\SDK\Transport\BaseTransport;

final class PromoCodeTransport extends BaseTransport
{

    /**
     * @throws UnknownException
     * @throws ApiClientException
     * @throws NetworkException
     */
    public function getPromoCode(string $code): PromoCodeDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/promo-code/%s', $code),
        );

        return PromoCodeDto::fromArray($result, $this->getDateTimeZone());
    }

    /**
     * @param HoldPromoCodeDto $holdPromoCodeDto
     * @return int
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function createHoldPromoCode(HoldPromoCodeDto $holdPromoCodeDto): int
    {
        $holdId = $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/hold-promo-code',
            $holdPromoCodeDto->toArray()
        );

        return (int)$holdId;
    }

    /**
     * @param int $holdId
     * @return HoldPromoCodeDto
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getHoldPromoCode(int $holdId): HoldPromoCodeDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/hold-promo-code/%s', $holdId),
        );

        return HoldPromoCodeDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @param int $holdId
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function deleteHoldPromoCode(int $holdId): void
    {
        $this->transport->request(
            RequestMethodInterface::METHOD_DELETE,
            sprintf('web-flow/hold-promo-code/%s', $holdId),
        );
    }

}
