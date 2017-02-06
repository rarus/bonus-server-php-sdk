<?php
namespace Rarus\BonusServer;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

use Rarus\BonusServer\Auth\Token;
use Rarus\BonusServer\Auth\TokenInterface;
use Rarus\BonusServer\Exceptions\BonusServerException;

/**
 * Class Client
 *
 * @package Rarus\BonusServer
 */
class Client
{
    /**
     * @var string
     */
    const AUTH_ROLE_ORGANIZATION = 'organization';

    /**
     * @var string
     */
    const AUTH_ROLE_CLIENT = 'client';

    /**
     * @var ClientInterface
     */
    protected $httpClient;
    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * @var HandlerStack
     */
    protected $guzzleHandlerStack;

    /**
     * @var string
     */
    protected $apiEndpoint;

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

        if ($obLogger !== null) {
            $this->log = $obLogger;
        } else {
            $this->log = new NullLogger();
        }

        $this->guzzleHandlerStack = HandlerStack::create();
        $this->guzzleHandlerStack->push(
            Middleware::log(
                $this->log,
                new MessageFormatter(MessageFormatter::DEBUG)
            )
        );

        $this->log->debug('init bonus server api wrapper');
    }

    /**
     * получение авторизационного токена для роли организация
     *
     * @param $login
     * @param $password
     * @param null $sessionId
     *
     * @throws \RuntimeException on failure.
     * @throws GuzzleException
     * @throws BonusServerException
     *
     * @return TokenInterface
     */
    public function getAuthTokenForOrganisationRole($login, $password, $sessionId = null)
    {
        $arResult = $this->executeApiRequest($this->apiEndpoint . '/sign_in', 'POST', [
            'handler' => $this->guzzleHandlerStack,
            'connect_timeout' => 1.5,
            'body' => json_encode([
                'login' => $login,
                'password' => sha1($password),
                'role' => self::AUTH_ROLE_ORGANIZATION,
                'session_id' => $sessionId
            ])
        ]);

        return new Token($arResult);
    }


    /**
     * @param $url
     * @param $requestType
     * @param $arHttpRequestOptions
     *
     * @throws \RuntimeException on failure.
     * @throws GuzzleException
     * @throws BonusServerException
     *
     * @return null|string
     */
    protected function executeApiRequest($url, $requestType, $arHttpRequestOptions)
    {
        $arResult = null;
        try {
            $obResponse = $this->httpClient->request($requestType, $url, $arHttpRequestOptions);

            print('Status:' . $obResponse->getStatusCode() . PHP_EOL);
            print('ReasonPhrase:' . $obResponse->getReasonPhrase() . PHP_EOL . '-------------' . PHP_EOL);


            $obResponseBody = $obResponse->getBody();
            $obResponseBody->rewind();

            // todo add handle network errors

            //get array from json
            $arResult = $this->decodeApiJsonResponse($obResponseBody->getContents());



        } catch (ClientException $e) {
            var_dump($e->getRequest());
            var_dump($e->getResponse());
        }

        return $arResult;
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
            /**
             * @todo add function json_last_error_msg()
             */
            $errorMsg = 'fatal error in function json_decode.' . PHP_EOL . 'Error code: ' . $jsonErrorCode . PHP_EOL;
            $this->log->error($errorMsg);
            throw new BonusServerException($errorMsg);
        }
        return $jsonResult;
    }
}