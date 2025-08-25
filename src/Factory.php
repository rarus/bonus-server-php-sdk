<?php

declare(strict_types=1);

namespace RarusBonus;

use DateTimeZone;
use Money\Currency;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RarusBonus\Transport\HttpTransport;

final class Factory
{
    private ?string $apiUrl = null;

    private ?string $organization = null;

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

    public function setOrganization(string $organization): Factory
    {
        $this->organization = $organization;

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
     * @throws Exceptions\UnknownException
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

        if ($this->organization === null) {
            throw new \InvalidArgumentException('Organization должен быть указан');
        }

        $currency = $this->currency ?? new Currency('RUB');
        $dateTimeZone = $this->dateTimeZone ?? new DateTimeZone('UTC');
        $logger = $this->logger ?? new NullLogger;
        if ($this->httpClient === null) {
            $this->httpClient = new \GuzzleHttp\Client([
                'base_uri' => $this->apiUrl,
                'connect_timeout' => 2,
                'headers' => [
                    'Cache-Control' => 'no-cache',
                    'Content-type' => 'application/json; charset=utf-8',
                ],
            ]);
        }

        $transport = new HttpTransport(
            $this->httpClient,
            $this->organization,
            $this->apiKey,
            $logger,
        );

        $client = new Client($transport, $logger, $currency, $dateTimeZone);

        $cacheKey = 'rarus_bonus_auth_token_'.md5($this->apiKey);

        if ($this->cache !== null && ($token = $this->cache->get($cacheKey))) {
            $transport->setAuthToken($token);
        } else {
            $token = $client->auth()->getNewAuthToken();
            $transport->setAuthToken($token);
            $this->cache?->set($cacheKey, $token, $token->getTtl());
        }

        return $client;
    }
}
