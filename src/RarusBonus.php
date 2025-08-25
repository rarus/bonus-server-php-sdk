<?php

declare(strict_types=1);

namespace RarusBonus;

final class RarusBonus
{
    public const SDK_VERSION = '2.0.0';

    public static function client(string $apiUrl, string $organization, string $apiKey): Client
    {
        return self::factory()
            ->setApiUrl($apiUrl)
            ->setOrganization($organization)
            ->setApiKey($apiKey)
            ->create();
    }

    public static function factory(): Factory
    {
        return new Factory;
    }
}
