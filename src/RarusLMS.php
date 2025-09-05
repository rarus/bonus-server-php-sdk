<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK;

use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;

final class RarusLMS
{
    public const SDK_VERSION = '2.0.0';

    private function __construct() {}

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     * @throws InvalidArgumentException
     */
    public static function client(string $apiUrl, string $apiKey): Client
    {
        return self::factory()
            ->setApiUrl($apiUrl)
            ->setApiKey($apiKey)
            ->create();
    }

    public static function factory(): Factory
    {
        return new Factory;
    }
}
