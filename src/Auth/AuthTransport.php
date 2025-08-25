<?php

declare(strict_types=1);

namespace RarusBonus\Auth;

use Fig\Http\Message\RequestMethodInterface;
use RarusBonus\Auth\DTO\AuthToken;
use RarusBonus\Exceptions\ApiClientException;
use RarusBonus\Exceptions\NetworkException;
use RarusBonus\Exceptions\UnknownException;
use RarusBonus\RarusBonus;
use RarusBonus\Transport\BaseTransport;

final class AuthTransport extends BaseTransport
{
    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getNewAuthToken(): AuthToken
    {
        $arResult = $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            '/integration-module/auth',
            [
                'id' => 'rarus_bonus_php_sdk',
                'version' => RarusBonus::SDK_VERSION,
                // 'meta': {"some-var-1": "val-1", "some-var-2": "val-2"}
            ]
        );

        return AuthToken::fromArray($arResult, $this->dateTimeZone);
    }
}
