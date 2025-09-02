<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Users\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\InvalidArgumentException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Transport\BaseTransport;
use Rarus\LMS\SDK\Users\DTO\UserDto;

class UsersTransport extends BaseTransport
{
    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function addNewUser(UserDto $userDto): UserDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/client',
            $userDto->toArray()
        );

        return UserDto::createFromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @throws ApiClientException
     * @throws UnknownException
     * @throws NetworkException
     * @throws InvalidArgumentException
     */
    public function updateUser(UserDto $userDto): void
    {
        if (!$userDto->id) {
            throw new InvalidArgumentException('User id cannot be null');
        }

        $body = $userDto->toArray();
        if (!empty($body['cards'])) {
            unset($body['cards']);
        }

        $result = $this->transport->request(
            RequestMethodInterface::METHOD_PUT,
            sprintf('web-flow/client/%s', $userDto->id),
            $body
        );
    }

    /**
     * @throws ApiClientException
     * @throws UnknownException
     * @throws NetworkException
     */
    public function getUserById(int $id, bool $withProperties = false): UserDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/client/%s?with_properties=%s', $id, (bool)$withProperties ? 'true' : 'false'),
        );

        return UserDto::createFromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getUserByPhone(int|string $phone): UserDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/client/by-phone/%s', $phone),
        );

        return UserDto::createFromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }
}
