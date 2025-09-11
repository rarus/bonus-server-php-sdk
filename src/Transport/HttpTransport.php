<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Transport;

use Fig\Http\Message\RequestMethodInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Http\Discovery\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use Rarus\LMS\SDK\Auth\DTO\AuthToken;
use Rarus\LMS\SDK\Contracts\TransportInterface;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Transport;
use Throwable;

final class HttpTransport implements TransportInterface
{
    private ?AuthToken $authToken = null;

    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly string $apiKey,
        private readonly LoggerInterface $logger,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function request(string $method, string $uri, array $data = []): mixed
    {
        $options = [];

        if ($data !== []) {
            $options['json'] = $data;
        }

        $auth = $uri === 'integration-module/auth'
            ? $this->apiKey
            : $this->authToken?->token;

        if ($auth !== null) {
            $options['headers']['Authorization'] = $auth;
        }

        // выполняем http-запрос
        $obResponse = $this->executeRequest(
            $method,
            $uri,
            $options
        );
        // получаем тело ответа от сервера
        $stream = $obResponse->getBody();
        $stream->rewind();

        // декодируем строку c JSON в массив
        $result = $this->decodeApiJsonResponse($stream->getContents());

        $this->handleApiLevelErrors($result, $obResponse->getStatusCode());

        return $result['data'] ?? [];
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function ping(): void
    {
        $this->request(RequestMethodInterface::METHOD_GET, 'web-flow/ping');
    }

    public function setAuthToken(AuthToken $authToken): HttpTransport
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $requestOptions
     *
     * @throws \JsonException
     */
    private function createRequest(string $requestType, string $uri, array $requestOptions): RequestInterface
    {
        $psr17Factory = new Psr17Factory;
        $body = null;

        if (isset($requestOptions['json'])) {
            $body = $psr17Factory->createStream(
                \json_encode($requestOptions['json'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        $request = $psr17Factory->createRequest($requestType, $uri);

        if ($body instanceof StreamInterface) {
            $request = $request->withBody($body);
        }

        if (! empty($requestOptions['headers'])) {
            foreach ($requestOptions['headers'] as $name => $value) {
                $request = $request->withHeader($name, $value);
            }
        }

        return $request;
    }

    /**
     * @param  array<string, mixed>  $requestOptions
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    private function executeRequest(string $requestType, string $url, array $requestOptions): ResponseInterface
    {
        $this->logger->debug('rarus.bonus.server.apiClient.executeRequest.start', [
            'request_type' => $requestType,
            'url' => $url,
            'request_options' => $requestOptions,
        ]);

        try {
            $request = $this->createRequest($requestType, $url, $requestOptions);
            $obResponse = $this->httpClient->sendRequest($request);
            $obResponseBody = $obResponse->getBody();
            $obResponseBody->rewind();
            $result = $this->decodeApiJsonResponse($obResponseBody->getContents());
        } catch (BadResponseException $exception) {
            // сервер вернул ответ, но выставил статус 4xx или 5xx
            $response = $exception->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            $result = $this->decodeApiJsonResponse($responseBodyAsString);
            $errorResponse = Transport\DTO\ErrorResponse::fromArray($result);

            throw new ApiClientException($result['message'], (int) $result['code'], $exception, $errorResponse);
        } catch (GuzzleException $exception) {
            // произошла ошибка на уровне сетевой подсистемы
            $this->logger->error(
                'rarus.bonus.server.apiClient.network.error',
                [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new NetworkException($exception->getMessage(), (int) $exception->getCode());
        } catch (Throwable $unhandledException) {
            // произошла неизвестная ошибка
            $this->logger->error(
                'rarus.bonus.server.apiClient.unknown.error',
                [
                    'type' => \get_class($unhandledException),
                    'code' => (int) $unhandledException->getCode(),
                    'message' => $unhandledException->getMessage(),
                    'trace' => $unhandledException->getTrace(),
                ]
            );

            throw new UnknownException(
                sprintf(
                    'Неизвестная ошибка (%s): %s',
                    get_class($unhandledException),
                    $unhandledException->getMessage()
                ),
                (int) $unhandledException->getCode(),
                $unhandledException
            );
        }

        $this->logger->debug('rarus.bonus.server.apiClient.executeRequest.finish', [
            'request_type' => $requestType,
            'url' => $url,
            'request_options' => $requestOptions,
            'result' => $result,
        ]);

        return $obResponse;
    }

    /**
     * @throws ApiClientException
     */
    private function decodeApiJsonResponse(string $jsonApiResponse): mixed
    {
        if ($jsonApiResponse === '') {
            $errorMsg = 'нет ответа от бонусного сервера';
            $this->logger->error($errorMsg);

            throw new ApiClientException($errorMsg);
        }

        $jsonResult = \json_decode($jsonApiResponse, true);
        $jsonErrorCode = \json_last_error();

        if ($jsonResult === null && ($jsonErrorCode !== JSON_ERROR_NONE)) {
            $errorMsg = sprintf(
                'ошибка при декодировании ответа от бонусного сервера при вызове функции json_decode, код ошибки: %s, текст ошибки: %s',
                $jsonErrorCode,
                \json_last_error_msg()
            );
            $this->logger->error($errorMsg);

            throw new ApiClientException($errorMsg);
        }

        return $jsonResult;
    }

    /**
     * Handles and processes API-level errors based on the server response and status code.
     *
     * @param  array<string, mixed>  $arBonusServerOperationResponse  The API response containing error details or operation results.
     * @param  int  $serverStatusCode  The HTTP status code returned by the server.
     *
     * @throws ApiClientException Thrown when an error occurs at the API level, based on response or status code.
     */
    private function handleApiLevelErrors(array $arBonusServerOperationResponse, int $serverStatusCode): void
    {
        $this->logger->debug('rarus.bonus.server.apiClient.handleApiLevelErrors.start', [
            'message' => $arBonusServerOperationResponse['message'],
            'serverStatus' => $serverStatusCode,
        ]);

        if ($serverStatusCode >= 400) {
            throw new ApiClientException(
                (string) $arBonusServerOperationResponse['message'],
                (int) $arBonusServerOperationResponse['code']
            );
        }

        if (isset($arBonusServerOperationResponse['success'])) {
            if ((bool) $arBonusServerOperationResponse['success'] === false) {
                $errorResponse = Transport\DTO\ErrorResponse::fromArray($arBonusServerOperationResponse);

                throw new ApiClientException(
                    trim($arBonusServerOperationResponse['message'] ?? 'Unknown error'),
                    $arBonusServerOperationResponse['code'] ?? $serverStatusCode,
                    null,
                    $errorResponse
                );
            }
        } else {
            throw new ApiClientException(
                'Unknown API error format',
                $serverStatusCode
            );
        }

        $this->logger->debug('rarus.bonus.server.apiClient.handleApiLevelErrors.finish');
    }
}
