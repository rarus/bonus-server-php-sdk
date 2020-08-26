<?php

declare(strict_types=1);

namespace Rarus\BonusServer;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp;
use Rarus\BonusServer;

/**
 * Class ApiClient
 *
 * @package Rarus\BonusServer
 */
class ApiClient
{
    /**
     * @var string SDK version
     */
    protected const SDK_VERSION = '1.0.0';

    /**
     * @var string user agent
     */
    protected const API_USER_AGENT = 'rarus.bonus.server';

    /**
     * @var GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * @var GuzzleHttp\HandlerStack
     */
    protected $guzzleHandlerStack;

    /**
     * @var string
     */
    protected $apiEndpoint;

    /**
     * @var BonusServer\Auth\DTO\AuthToken|null
     */
    protected $authToken;
    /**
     * @var float number of seconds to wait while trying to connect to a server. Use 0 to wait indefinitely (the default behavior).
     */
    protected $connectTimeout;
    /**
     * @var \DateTimeZone временная зона в которой работает API-клиент, по умолчанию берётся зона установленная на сервере
     */
    protected $timezone;

    /**
     * ApiClient constructor.
     *
     * @param string                        $apiEndpointUrl
     * @param GuzzleHttp\ClientInterface    $obHttpClient
     * @param \Psr\Log\LoggerInterface|null $obLogger
     */
    public function __construct(string $apiEndpointUrl, GuzzleHttp\ClientInterface $obHttpClient, LoggerInterface $obLogger = null)
    {
        if ($obLogger !== null) {
            $this->log = $obLogger;
        } else {
            $this->log = new NullLogger();
        }
        $this->apiEndpoint = $apiEndpointUrl;
        $this->httpClient = $obHttpClient;
        $this->setConnectTimeout(2.0);
        $this->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        $this->guzzleHandlerStack = GuzzleHttp\HandlerStack::create();

        $this->log->debug(
            'rarus.bonus.server.apiClient.init',
            [
                'url' => $apiEndpointUrl,
                'connect_timeout' => $this->getConnectTimeout(),
                'timezone' => $this->getTimezone()->getName(),
            ]
        );
    }

    /**
     * @return float
     */
    public function getConnectTimeout(): float
    {
        return $this->connectTimeout;
    }

    /**
     * @param float $connectTimeout
     *
     * @return ApiClient
     */
    public function setConnectTimeout(float $connectTimeout): ApiClient
    {
        $this->log->debug('rarus.bonus.server.apiClient.setConnectTimeout.start', [
            'connectTimeout' => $connectTimeout,
        ]);
        $this->connectTimeout = $connectTimeout;
        $this->log->debug('rarus.bonus.server.apiClient.setConnectTimeout.finish');

        return $this;
    }

    /**
     * @return \DateTimeZone
     */
    public function getTimezone(): \DateTimeZone
    {
        return $this->timezone;
    }

    /**
     * @param \DateTimeZone $timezone
     *
     * @return ApiClient
     */
    public function setTimezone(\DateTimeZone $timezone): ApiClient
    {
        $this->log->debug('rarus.bonus.server.apiClient.setTimezone.start', [
            'name' => $timezone->getName(),
        ]);
        $this->timezone = $timezone;
        $this->log->debug('rarus.bonus.server.apiClient.setTimezone.finish');

        return $this;
    }

    /**
     * @param Auth\DTO\Credentials $credentials
     *
     * @return Auth\DTO\AuthToken
     * @throws Exceptions\ApiClientException
     * @throws Exceptions\NetworkException
     * @throws Exceptions\UnknownException
     */
    public function getNewAuthToken(BonusServer\Auth\DTO\Credentials $credentials): BonusServer\Auth\DTO\AuthToken
    {
        $this->log->debug('rarus.bonus.server.apiClient.getNewAuthToken.start', [
            'credentials' => Auth\Formatters\Credentials::toArray($credentials),
        ]);

        $arResult = $this->executeApiRequest(
            '/sign_in',
            RequestMethodInterface::METHOD_POST,
            BonusServer\Auth\Formatters\Credentials::toArray($credentials)
        );

        $authToken = Auth\Fabric::initAuthTokenFromResponseArray($arResult);

        $this->log->debug('rarus.bonus.server.apiClient.getNewAuthToken.finish', [
            'authToken' => Auth\Formatters\AuthToken::toArray($authToken),
        ]);

        return $authToken;
    }

    /**
     * выполнение API-запроса к бонусному серверу
     *
     * @param       $apiMethod
     * @param       $requestType
     * @param array $arHttpRequestOptions
     *
     * @return array
     * @throws Exceptions\ApiClientException
     * @throws Exceptions\NetworkException
     * @throws Exceptions\UnknownException
     */
    public function executeApiRequest($apiMethod, $requestType, array $arHttpRequestOptions = []): array
    {
        if (\count($arHttpRequestOptions) !== 0) {
            $defaultHttpRequestOptions = \array_merge(['json' => $arHttpRequestOptions], $this->getHttpRequestOptions());
        } else {
            $defaultHttpRequestOptions = $this->getHttpRequestOptions();
        }

        $this->log->debug('rarus.bonus.server.apiClient.executeApiRequest.start', [
            'url' => $this->apiEndpoint . $apiMethod,
            'method' => $apiMethod,
            'request_type' => $requestType,
            'options' => $defaultHttpRequestOptions,
        ]);

        // выполняем http-запрос
        $obResponse = $this->executeRequest($requestType, $this->apiEndpoint . $apiMethod, $defaultHttpRequestOptions);
        // получаем тело ответа от сервера
        $obResponseBody = $obResponse->getBody();
        $obResponseBody->rewind();

        // декодируем строку c JSON в массив
        $result = $this->decodeApiJsonResponse($obResponseBody->getContents());

        $this->handleApiLevelErrors($result, $obResponse->getStatusCode());

        $this->log->debug('rarus.bonus.server.apiClient.executeApiRequest.finish', [
            'result' => $result,
        ]);

        return $result;
    }

    /**
     * get HttpRequest options
     *
     * @return array
     */
    protected function getHttpRequestOptions(): array
    {
        $arResult = [
            'connect_timeout' => $this->getConnectTimeout(),
            'headers' => [
                'Cache-Control' => 'no-cache',
                'Content-type' => 'application/json; charset=utf-8',
                'X-ENVIRONMENT-PHP-VERSION' => \PHP_VERSION,
                'X-ENVIRONMENT-SDK-VERSION' => \strtolower(self::API_USER_AGENT . '-v' . self::SDK_VERSION),
            ],
        ];

        if ($this->getAuthToken() !== null) {
            $arResult['headers']['token'] = $this->getAuthToken()->getToken();
        }

        return $arResult;
    }

    /**
     * @return null|Auth\DTO\AuthToken
     */
    public function getAuthToken(): ?Auth\DTO\AuthToken
    {
        return $this->authToken;
    }

    /**
     * @param Auth\DTO\AuthToken $authToken
     *
     * @return ApiClient
     */
    public function setAuthToken(Auth\DTO\AuthToken $authToken): ApiClient
    {
        $this->log->debug('rarus.bonus.server.apiClient.setAuthToken.start', [
            'token' => $authToken->getToken(),
            'company_id' => $authToken->getCompanyId(),
            'code' => $authToken->getCode(),
            'expires' => $authToken->getExpires(),
        ]);

        $this->authToken = $authToken;

        $this->log->debug('rarus.bonus.server.apiClient.setAuthToken.finish');

        return $this;
    }

    /**
     * @param string $requestType
     * @param string $url
     * @param array  $requestOptions
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws Exceptions\ApiClientException
     * @throws Exceptions\NetworkException
     * @throws Exceptions\UnknownException
     */
    protected function executeRequest(string $requestType, string $url, array $requestOptions): \Psr\Http\Message\ResponseInterface
    {
        $this->log->debug('rarus.bonus.server.apiClient.executeRequest.start', [
            'request_type' => $requestType,
            'url' => $url,
            'request_options' => $requestOptions,
        ]);

        try {
            $obResponse = $this->httpClient->request($requestType, $url, $requestOptions);
            $obResponseBody = $obResponse->getBody();
            $obResponseBody->rewind();
            $result = $this->decodeApiJsonResponse($obResponseBody->getContents());
        } catch (GuzzleHttp\Exception\BadResponseException $exception) {
            // сервер вернул ответ, но выставил статус 4xx или 5xx
            $response = $exception->getResponse();
            $responseBodyAsString = '';
            if ($response !== null) {
                $responseBodyAsString = $response->getBody()->getContents();
            }
            $result = $this->decodeApiJsonResponse($responseBodyAsString);
            $this->log->error(
                'rarus.bonus.server.apiClient.backend.error',
                [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'server_response' => $responseBodyAsString,
                    'decodedResponse' => $result,
                ]
            );
            throw new BonusServer\Exceptions\ApiClientException($result['message'], (int)$result['code']);
        } catch (GuzzleHttp\Exception\GuzzleException $exception) {
            // произошла ошибка на уровне сетевой подсистемы
            $this->log->error(
                'rarus.bonus.server.apiClient.network.error',
                [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new BonusServer\Exceptions\NetworkException($exception->getMessage(), $exception->getCode());
        } catch (\Throwable $unhandledException) {
            // произошла неизвестная ошибка
            $this->log->error(
                'rarus.bonus.server.apiClient.unknown.error',
                [
                    'type' => \get_class($unhandledException),
                    'code' => $unhandledException->getCode(),
                    'message' => $unhandledException->getMessage(),
                    'trace' => $unhandledException->getTrace(),
                ]
            );

            throw new BonusServer\Exceptions\UnknownException(
                'неизвестная ошибка: ' . $unhandledException->getMessage(),
                $unhandledException->getCode()
            );
        }

        $this->log->debug('rarus.bonus.server.apiClient.executeRequest.finish', [
            'request_type' => $requestType,
            'url' => $url,
            'request_options' => $requestOptions,
            'http_status' => $obResponse->getStatusCode(),
            'result' => $result,
        ]);

        return $obResponse;
    }

    /**
     * @param $jsonApiResponse
     *
     * @return mixed
     * @throws Exceptions\ApiClientException
     */
    protected function decodeApiJsonResponse($jsonApiResponse)
    {
        if ($jsonApiResponse === '') {
            $errorMsg = \sprintf('нет ответа от бонусного сервера');
            $this->log->error($errorMsg);

            throw new BonusServer\Exceptions\ApiClientException($errorMsg);
        }

        $jsonResult = \json_decode($jsonApiResponse, true);
        $jsonErrorCode = \json_last_error();

        if (null === $jsonResult && (JSON_ERROR_NONE !== $jsonErrorCode)) {
            $errorMsg = sprintf(
                'ошибка при декодировании ответа от бонусного сервера при вызове функции json_decode, код ошибки: %s, текст ошибки: %s',
                $jsonErrorCode,
                \json_last_error_msg()
            );
            $this->log->error($errorMsg);

            throw new BonusServer\Exceptions\ApiClientException($errorMsg);
        }

        return $jsonResult;
    }

    /**
     * обработка ошибок уровня бизнес-логики бонусного сервера
     *
     * @param array $arBonusServerOperationResponse
     * @param int   $serverStatusCode
     *
     * @throws Exceptions\ApiClientException
     */
    protected function handleApiLevelErrors(array $arBonusServerOperationResponse, int $serverStatusCode): void
    {
        $this->log->debug('rarus.bonus.server.apiClient.handleApiLevelErrors.start', [
            'code' => $arBonusServerOperationResponse['code'],
            'message' => $arBonusServerOperationResponse['message'],
            'serverStatus' => $serverStatusCode,
        ]);

        switch ($serverStatusCode) {
            case StatusCodeInterface::STATUS_OK:
            case StatusCodeInterface::STATUS_ACCEPTED:
                // ошибок на уровне cтатуса сервера нет, анализировать ошибки бизнес-логики не требуется
                break;
            default:
                //  есть ошибки на уровне статуса сервера
                throw new BonusServer\Exceptions\ApiClientException(
                    (string)$arBonusServerOperationResponse['message'],
                    (int)$arBonusServerOperationResponse['code']
                );
                break;
        }
        $this->log->debug('rarus.bonus.server.apiClient.handleApiLevelErrors.finish');
    }

    /**
     * @return GuzzleHttp\HandlerStack
     */
    protected function getGuzzleHandlerStack(): GuzzleHttp\HandlerStack
    {
        return $this->guzzleHandlerStack;
    }

    /**
     * @param GuzzleHttp\HandlerStack $guzzleHandlerStack
     *
     * @return ApiClient
     */
    public function setGuzzleHandlerStack(GuzzleHttp\HandlerStack $guzzleHandlerStack): ApiClient
    {
        $this->log->debug('rarus.bonus.server.apiClient.setGuzzleHandlerStack.start');
        $this->guzzleHandlerStack = $guzzleHandlerStack;
        $this->log->debug('rarus.bonus.server.apiClient.setGuzzleHandlerStack.finish');

        return $this;
    }
}
