<?php

namespace Rarus\LMS\SDK\Contracts;

use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;

interface TransportInterface
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function request(string $method, string $uri, array $data = []): mixed;
}
