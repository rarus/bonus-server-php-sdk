<?php

declare(strict_types=1);

namespace RarusBonus\Cards\Transport;

use Fig\Http\Message\RequestMethodInterface;
use RarusBonus\Cards\DTO\CardDto;
use RarusBonus\Exceptions\ApiClientException;
use RarusBonus\Exceptions\NetworkException;
use RarusBonus\Exceptions\UnknownException;
use RarusBonus\Transport\BaseTransport;

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
            sprintf('/web-flow/card/by-id/%s', $id),
        );

        return CardDto::createFromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
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
            sprintf('/web-flow/card/by-barcode/%s', $barcode),
        );

        return CardDto::createFromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }
}
