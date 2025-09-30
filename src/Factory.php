<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK;

use DateTimeZone;
use Money\Currency;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Transport\HttpTransport;

final class Factory
{
    private ?string $apiUrl = null;

    private ?string $apiKey = null;

    private ?ClientInterface $httpClient = null;

    private ?LoggerInterface $logger = null;

    private ?Currency $currency = null;

    private ?DateTimeZone $dateTimeZone = null;

    private ?CacheInterface $cache = null;

    public function setApiUrl(string $apiUrl): Factory
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    public function setApiKey(string $apiKey): Factory
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setHttpClient(ClientInterface $httpClient): Factory
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    public function setLogger(LoggerInterface $logger): Factory
    {
        $this->logger = $logger;

        return $this;
    }

    public function setCurrency(Currency $currency): Factory
    {
        $this->currency = $currency;

        return $this;
    }

    public function setDateTimeZone(DateTimeZone $dateTimeZone): Factory
    {
        $this->dateTimeZone = $dateTimeZone;

        return $this;
    }

    public function setCache(CacheInterface $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @throws Exceptions\ApiClientException
     * @throws Exceptions\NetworkException
     * @throws InvalidArgumentException
     */
    public function create(): Client
    {
        if ($this->apiUrl === null) {
            throw new \InvalidArgumentException('API URL должен быть указан');
        }

        if ($this->apiKey === null) {
            throw new \InvalidArgumentException('API Key должен быть указан');
        }

        $currency = $this->currency ?? new Currency('RUB');

        $dateTimeZone = $this->dateTimeZone ?? new DateTimeZone('UTC');

        $logger = $this->logger ?? new NullLogger;

        if (!$this->httpClient instanceof ClientInterface) {
            $this->httpClient = new \GuzzleHttp\Client([
                'base_uri' => $this->apiUrl,
                'connect_timeout' => 2,
                'headers' => [
                    'Cache-Control' => 'no-cache',
                    'Content-type' => 'application/json; charset=utf-8',
                ],
            ]);
        }

        $httpTransport = new HttpTransport(
            $this->httpClient,
            $this->apiKey,
            $logger,
        );

        return new Client($httpTransport, $logger, $this->cache, $currency, $dateTimeZone);
    }
}
