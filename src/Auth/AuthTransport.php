<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Auth;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Auth\DTO\AuthToken;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\RarusLMS;
use Rarus\LMS\SDK\Transport\BaseTransport;

final class AuthTransport extends BaseTransport
{
    /**
     * @throws ApiClientException
     * @throws NetworkException|UnknownException
     */
    public function getNewAuthToken(): AuthToken
    {
        $arResult = $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'integration-module/auth',
            [
                'id' => 'rarus_bonus_php_sdk',
                'version' => RarusLMS::SDK_VERSION,
                // 'meta': {"some-var-1": "val-1", "some-var-2": "val-2"}
            ]
        );

        return AuthToken::fromArray($arResult, $this->dateTimeZone);
    }
}
