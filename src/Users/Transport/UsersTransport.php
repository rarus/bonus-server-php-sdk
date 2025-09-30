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
use Rarus\LMS\SDK\Users\DTO\UserProperty\Property;

class UsersTransport extends BaseTransport
{
    /**
     * @throws ApiClientException
     * @throws NetworkException|UnknownException
     */
    public function addNewUser(UserDto $userDto): UserDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/client',
            $userDto->toArray()
        );

        return UserDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @throws ApiClientException
     * @throws InvalidArgumentException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function updateUser(UserDto $userDto): void
    {
        if ($userDto->id === null || $userDto->id === 0) {
            throw new InvalidArgumentException('User id cannot be null');
        }

        $body = $userDto->toArray();
        if (! empty($body['cards'])) {
            unset($body['cards']);
        }

        $this->transport->request(
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
            sprintf('web-flow/client/%s?with_properties=%s', $id, $withProperties ? 'true' : 'false'),
        );

        return UserDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
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

        return UserDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * @return array<Property>
     *
     * @throws UnknownException
     * @throws ApiClientException
     * @throws NetworkException
     */
    public function getUserProperties(): array
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            'web-flow/client/property'
        );

        return array_map(fn (array $property): Property => Property::fromArray($property, $this->getDateTimeZone()), $result);
    }
}
