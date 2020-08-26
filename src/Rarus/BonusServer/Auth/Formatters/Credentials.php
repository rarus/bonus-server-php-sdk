<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Auth\Formatters;

use Rarus\BonusServer\Auth\DTO\Credentials as CredentialsItem;

/**
 * Class Credentials
 *
 * @package Rarus\BonusServer\Auth\Formatters
 */
class Credentials
{

    /**
     * @param CredentialsItem $credentials
     *
     * @return string
     */
    public function toJson(CredentialsItem $credentials): string
    {
        return \json_encode(self::toArray($credentials));
    }

    /**
     * @param CredentialsItem $credentials
     *
     * @return array
     */
    public static function toArray(CredentialsItem $credentials): array
    {
        $arCredentials = [
            'login' => $credentials->getLogin(),
            'password' => $credentials->getPassword(),
            'role' => $credentials->getRole(),
            'session_id' => $credentials->getSession(),
        ];

        if ($credentials->getCompanyId() !== null) {
            $arCredentials['company_id'] = $credentials->getCompanyId();
        }

        return $arCredentials;
    }
}
