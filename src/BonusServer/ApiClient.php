<?php

namespace Rarus\BonusServer;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

use Rarus\BonusServer\Auth\DTO\AuthToken;
use Rarus\BonusServer\Exceptions\ApiBonusServerException;
use Rarus\BonusServer\Exceptions\BonusServerException;

/**
 * Class ApiClient
 *
 * @package Rarus\BonusServer
 */
class ApiClient implements ApiClientInterface
{
    /**
     * @var string SDK version
     */
    const SDK_VERSION = '1.0.0';
    /**
     * @var string user agent
     */
    const API_USER_AGENT = 'rarus-bonus-server-php-sdk';

    /**
     * @var ClientInterface
     */
    protected $httpClient;
    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * @var string
     */
    protected $apiEndpoint;

    /**
     * @var AuthToken
     */
    protected $authToken;

    /**
     * @var float
     */
    protected $connectTimeout;

    /**
     * Client constructor.
     *
     * @param string $apiEndpointUrl
     * @param ClientInterface $obHttpClient
     * @param LoggerInterface|null $obLogger
     */
    public function __construct($apiEndpointUrl, ClientInterface $obHttpClient, LoggerInterface $obLogger = null)
    {
        $this->apiEndpoint = $apiEndpointUrl;
        $this->httpClient = $obHttpClient;
        $this->authToken = null;

        if ($obLogger !== null) {
            $this->log = $obLogger;
        } else {
            $this->log = new NullLogger();
        }
        $this->setConnectTimeout(2);

        $this->log->debug('rarus.BonusServer.ApiClient.init', [
            'apiEndpoint' => $this->apiEndpoint,
        ]);
    }

    /**
     * @param $apiMethod
     * @param $requestType
     * @param $arHttpRequestOptions
     *
     * @throws \RuntimeException on failure.
     * @throws BonusServerException
     * @throws ApiBonusServerException
     * @throws \LogicException
     *
     * @return null|array
     */
    public function executeApiRequest($apiMethod, $requestType, array $arHttpRequestOptions = array())
    {
        $this->log->debug('rarus.BonusServer.ApiClient.executeApiRequest.start', [
            'apiMethod' => $apiMethod,
            'requestType' => $requestType,
            'requestOptions' => $arHttpRequestOptions,
        ]);

        $arResult = null;

        $defaultHttpRequestOptions = array_merge($arHttpRequestOptions, $this->getDefaultHttpRequestOptions());
        // add auth headers
        $defaultHttpRequestOptions['headers']['token'] = (null === $this->authToken) ? '' : $this->authToken->getToken();

        try {
            $this->log->debug('rarus.BonusServer.ApiClient.executeApiRequest.createRequest', [
                'requestType' => $requestType,
                'url' => $this->apiEndpoint . $apiMethod,
                'requestOptions' => $defaultHttpRequestOptions,
            ]);

            $obRequest = $this->httpClient->createRequest($requestType, $this->apiEndpoint . $apiMethod, $defaultHttpRequestOptions);
            $obResponse = $this->httpClient->send($obRequest);
            $this->log->debug('rarus.BonusServer.ApiClient.executeApiRequest.requestResultInfo', [
                'statusCode' => $obResponse->getStatusCode(),
                'reasonPhrase' => $obResponse->getReasonPhrase(),
                'effectiveUrl' => $obResponse->getEffectiveUrl(),
            ]);

            $obResponseBody = $obResponse->getBody();
            $arResult = $this->decodeApiJsonResponse($obResponseBody->getContents());

            $this->log->debug('rarus.BonusServer.ApiClient.executeApiRequest.requestResult', [
                'result' => $arResult,
            ]);

        } catch (RequestException $e) {
            $this->log->error(sprintf('http client error [%s]', $e->getMessage()));
            $this->handleBonusServerApiErrors($e);
        }

        return $arResult;
    }

    /**
     * get default HttpRequest options
     *
     * @return array
     */
    protected function getDefaultHttpRequestOptions()
    {
        return [
            'connect_timeout' => $this->getConnectTimeout(),
            'headers' => [
                'X-ENVIRONMENT-PHP-VERSION' => PHP_VERSION,
                'X-ENVIRONMENT-SDK-VERSION' => strtolower(self::API_USER_AGENT . '-v' . self::SDK_VERSION),
            ],
        ];
    }

    /**
     * @return float
     */
    protected function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * @param $connectTimeout
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = (float)$connectTimeout;
    }

    /**
     * @param $jsonApiResponse
     *
     * @return mixed
     * @throws BonusServerException
     */
    protected function decodeApiJsonResponse($jsonApiResponse)
    {
        // handling server-side API errors: empty response
        if ($jsonApiResponse === '') {
            $errorMsg = sprintf('empty response from server');
            $this->log->error($errorMsg);
            throw new BonusServerException($errorMsg);
        }
        // handling json_decode errors
        $jsonResult = json_decode($jsonApiResponse, true);
        $jsonErrorCode = json_last_error();
        if (null === $jsonResult && (JSON_ERROR_NONE !== $jsonErrorCode)) {
            $errorMsg = 'fatal error in function json_decode.' . PHP_EOL . 'Error code: ' . $jsonErrorCode . PHP_EOL;
            $this->log->error($errorMsg);
            throw new BonusServerException($errorMsg);
        }

        return $jsonResult;
    }

    /**
     * @param RequestException $clientException
     *
     * @throws ApiBonusServerException
     * @throws BonusServerException
     * @return void
     */
    protected function handleBonusServerApiErrors(RequestException $clientException)
    {
        $obErrorResponse = $clientException->getResponse();
        $obStream = $obErrorResponse->getBody();
        $arServerResponse = $this->decodeApiJsonResponse($obStream->getContents());

        $errorMessage = sprintf('bonus server error: code [%s], message [%s], ',
            $arServerResponse['code'], $arServerResponse['message']);

        $this->log->error($errorMessage);

        throw new ApiBonusServerException($errorMessage);
    }

    /**
     * @param AuthToken $authToken
     */
    public function setAuthToken(AuthToken $authToken)
    {
        $this->authToken = $authToken;
    }
}