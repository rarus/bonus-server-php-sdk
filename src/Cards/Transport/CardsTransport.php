<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Cards\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Cards\DTO\CardDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Transport\BaseTransport;

class CardsTransport extends BaseTransport
{
    /**
     * @throws ApiClientException
     * @throws UnknownException
     * @throws NetworkException
     */
    public function getCardById(int $id): CardDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/card/by-id/%s', $id),
        );

        return CardDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getCardByBarCode(string $barcode): CardDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/card/by-barcode/%s', $barcode),
        );

        return CardDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }
}
