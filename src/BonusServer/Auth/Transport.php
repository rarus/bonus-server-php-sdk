<?php

namespace Rarus\BonusServer\Auth;

use Rarus\BonusServer\ApiClientInterface;
use Rarus\BonusServer\Exceptions\ApiBonusServerException;
use Rarus\BonusServer\Exceptions\BonusServerException;
use Rarus\BonusServer\Auth\DTO\AuthToken;

use Psr\Log\LoggerInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Auth
 */
class Transport
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;
    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * Transport constructor.
     *
     * @param ApiClientInterface $apiClient
     * @param LoggerInterface $logger
     */
    public function __construct(ApiClientInterface $apiClient, LoggerInterface $logger)
    {
        $this->apiClient = $apiClient;
        $this->log = $logger;

        $this->log->debug('rarus.bonusServer.auth.transport.init');
    }

    /**
     * получение авторизационного токена для роли «Организация»
     *
     * @param $login
     * @param $password
     * @param $sessionId
     *
     * @throws \RuntimeException on failure.
     * @throws BonusServerException
     * @throws ApiBonusServerException
     *
     * @return AuthToken
     */
    public function getAuthTokenForOrganizationRole($login, $password, $sessionId = '')
    {
        $this->log->debug('rarus.bonusServer.auth.transport.getAuthTokenForOrganizationRole.start', [
            'login' => $login,
            'password' => $password,
            'sessionId' => $sessionId,
        ]);

        $arResult = $this->apiClient->executeApiRequest('/sign_in', 'POST', [
            'body' => json_encode([
                'login' => $login,
                'password' => sha1($password),
                'role' => 'organization',
                'session_id' => $sessionId,
            ]),
        ]);
        $this->log->debug('rarus.bonusServer.auth.transport.getAuthTokenForOrganizationRole.request', [
            'request' => $arResult,
        ]);

        $authToken = AuthToken::initFromArray($arResult);

        $this->log->debug('rarus.bonusServer.auth.transport.getAuthTokenForOrganizationRole.finish', [
            'authToken' => $authToken->toArray(),
        ]);

        return $authToken;
    }

    /**
     * получение авторизационного токена для роли «Клиент»
     *
     * @param $login
     * @param $password
     * @param $sessionId
     *
     * @throws \RuntimeException on failure.
     * @throws BonusServerException
     * @throws ApiBonusServerException
     *
     * @return AuthToken
     */
    public function getAuthTokenForClientRole($login, $password, $sessionId = '')
    {
        $this->log->debug('rarus.bonusServer.auth.transport.getAuthTokenForClientRole.start', [
            'login' => $login,
            'password' => $password,
            'sessionId' => $sessionId,
        ]);

        $arResult = $this->apiClient->executeApiRequest('/sign_in', 'POST', [
            'body' => json_encode([
                'login' => $login,
                'password' => sha1($password),
                'role' => 'client',
                'session_id' => $sessionId,
            ]),
        ]);
        $this->log->debug('rarus.bonusServer.auth.transport.getAuthTokenForClientRole.request', [
            'request' => $arResult,
        ]);

        $authToken = AuthToken::initFromArray($arResult);

        $this->log->debug('rarus.bonusServer.auth.transport.getAuthTokenForClientRole.finish', [
            'authToken' => $authToken->toArray(),
        ]);

        return $authToken;
    }
}