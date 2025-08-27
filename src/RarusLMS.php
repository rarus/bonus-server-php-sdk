<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK;

final class RarusLMS
{
    public const SDK_VERSION = '2.0.0';

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
