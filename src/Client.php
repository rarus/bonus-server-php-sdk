<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK;

use Money\Currency;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Auth\AuthTransport;
use Rarus\LMS\SDK\Cards\Transport\CardsTransport;
use Rarus\LMS\SDK\Contracts\TransportInterface;
use Rarus\LMS\SDK\Discounts\Transport\DiscountTransport;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Holds\Transport\HoldTransport;
use Rarus\LMS\SDK\PromoСodes\Transport\PromoCodeTransport;
use Rarus\LMS\SDK\Transport\CachedTransport;
use Rarus\LMS\SDK\Transport\HttpTransport;
use Rarus\LMS\SDK\Users\Transport\UsersTransport;

final readonly class Client
{
    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws InvalidArgumentException
     */
    public function __construct(
        private HttpTransport $transport,
        private LoggerInterface $logger,
        private ?CacheInterface $cache = null,
        private Currency $currency = new Currency('RUB'),
        private \DateTimeZone $timeZone = new \DateTimeZone('UTC'),
    ) {
        $this->authorize();
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws InvalidArgumentException
     */
    public function authorize(): void
    {
        $authTransport = new AuthTransport($this->transport, $this->logger, $this->currency, $this->timeZone);
        $cacheKey = 'rarus_lms_auth_token';

        if ($this->cache !== null && ($token = $this->cache->get($cacheKey))) {
            $this->transport->setAuthToken($token);
            $this->logger->debug('Using cached auth token');
        } else {
            $token = $authTransport->getNewAuthToken();
            $this->transport->setAuthToken($token);
            $this->cache?->delete($cacheKey);
            $this->cache?->set($cacheKey, $token, $token->getTtl());
        }
    }

    public function clearCache(): void
    {
        $this->cache?->clear();
    }

    private function wrapTransport(?int $ttl = null): TransportInterface
    {
        if ($this->cache && $ttl) {
            return new CachedTransport($this->transport, $this->cache, $this->logger, $ttl);
        }

        return $this->transport;
    }

    public function transport(): HttpTransport
    {
        return $this->transport;
    }

    public function users(?int $ttl = null): UsersTransport
    {
        return new UsersTransport($this->wrapTransport($ttl), $this->logger, $this->currency, $this->timeZone);
    }

    public function cards(?int $ttl = null): CardsTransport
    {
        return new CardsTransport($this->wrapTransport($ttl), $this->logger, $this->currency, $this->timeZone);
    }

    public function discounts(?int $ttl = null): DiscountTransport
    {
        return new DiscountTransport($this->wrapTransport($ttl), $this->logger, $this->currency, $this->timeZone);
    }

    public function holds(?int $ttl = null): HoldTransport
    {
        return new HoldTransport($this->wrapTransport($ttl), $this->logger, $this->currency, $this->timeZone);
    }

    public function promoCodes(?int $ttl = null): PromoCodeTransport
    {
        return new PromoCodeTransport($this->wrapTransport($ttl), $this->logger, $this->currency, $this->timeZone);
    }
}
