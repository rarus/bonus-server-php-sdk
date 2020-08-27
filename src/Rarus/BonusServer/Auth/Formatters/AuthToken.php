<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Auth\Formatters;

use Rarus\BonusServer\Auth\DTO\AuthToken as AuthTokenItem;

/**
 * Class AuthToken
 *
 * @package Rarus\BonusServer\Shops\Formatters
 */
class AuthToken
{
    /**
     * @param AuthTokenItem $authToken
     *
     * @return string
     */
    public function toJson(AuthTokenItem $authToken): string
    {
        return \json_encode(self::toArray($authToken));
    }

    /**
     * @param AuthTokenItem $authToken
     *
     * @return array
     */
    public static function toArray(AuthTokenItem $authToken): array
    {
        return [
            'token' => $authToken->getToken(),
            'message' => $authToken->getMessage(),
            'code' => $authToken->getCode(),
            'expires' => $authToken->getExpires(),
            'company_id' => $authToken->getCompanyId(),
        ];
    }
}
