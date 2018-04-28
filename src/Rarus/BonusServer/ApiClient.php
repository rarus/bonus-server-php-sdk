<?php
declare(strict_types=1);

namespace Rarus\BonusServer;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;

use Fig\Http\Message\RequestMethodInterface;

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
     * ApiClient constructor.
     *
     * @param string                        $apiEndpointUrl
     * @param GuzzleHttp\ClientInterface    $obHttpClient
     * @param \Psr\Log\LoggerInterface|null $obLogger
     */
    public function __construct(string $apiEndpointUrl, GuzzleHttp\ClientInterface $obHttpClient, LoggerInterface $obLogger = null)
    {
        $this->apiEndpoint = $apiEndpointUrl;
        $this->httpClient = $obHttpClient;
        $this->setConnectTimeout(2.0);

        if ($obLogger !== null) {
            $this->log = $obLogger;
        } else {
            $this->log = new NullLogger();
        }
        $this->guzzleHandlerStack = GuzzleHttp\HandlerStack::create();

        $this->log->debug(
            'rarus.bonus.server.apiClient.init',
            [
                'url' => $apiEndpointUrl,
                'connect_timeout' => $this->getConnectTimeout(),
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
     */
    public function setConnectTimeout(float $connectTimeout): void
    {
        $this->connectTimeout = $connectTimeout;
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
        $defaultHttpRequestOptions = \array_merge(['json' => $arHttpRequestOptions], $this->getHttpRequestOptions());

        $this->log->debug('rarus.bonus.server.apiClient.executeApiRequest.start', [
            'url' => $this->apiEndpoint . $apiMethod,
            'method' => $apiMethod,
            'request_type' => $requestType,
            'options' => $defaultHttpRequestOptions,
        ]);

        $result = $this->executeRequest($requestType, $this->apiEndpoint . $apiMethod, $defaultHttpRequestOptions);

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
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @param string $requestType
     * @param string $url
     * @param array  $requestOptions
     *
     * @return array
     * @throws Exceptions\ApiClientException
     * @throws Exceptions\NetworkException
     * @throws Exceptions\UnknownException
     */
    protected function executeRequest(string $requestType, string $url, array $requestOptions): array
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
                ]
            );
            throw new BonusServer\Exceptions\ApiClientException($result['message'], (int)$result['code'], $exception);
        } catch (GuzzleHttp\Exception\GuzzleException $exception) {
            // произошла ошибка на уровне сетевой подсистемы
            $this->log->error(
                'rarus.bonus.server.apiClient.network.error',
                [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new BonusServer\Exceptions\NetworkException($exception->getMessage(), $exception->getCode(), $exception);
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
                $unhandledException->getCode(),
                $unhandledException);
        }

        $this->log->debug('rarus.bonus.server.apiClient.executeRequest.finish', [
            'request_type' => $requestType,
            'url' => $url,
            'request_options' => $requestOptions,
            'result' => $result,
        ]);

        return $result;
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
            $errorMsg = sprintf('ошибка при декодировании ответа от бонусного сервера при вызове функции json_decode, код ошибки: %s, текст ошибки: %s',
                $jsonErrorCode,
                \json_last_error_msg());
            $this->log->error($errorMsg);

            throw new BonusServer\Exceptions\ApiClientException($errorMsg);
        }

        return $jsonResult;
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
     */
    public function setGuzzleHandlerStack(GuzzleHttp\HandlerStack $guzzleHandlerStack): void
    {
        $this->guzzleHandlerStack = $guzzleHandlerStack;
    }
}