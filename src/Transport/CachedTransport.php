<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Transport;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Contracts\TransportInterface;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;

final readonly class CachedTransport implements TransportInterface
{
    public function __construct(
        private TransportInterface $transport,
        private CacheInterface $cache,
        private LoggerInterface $logger,
        private int $ttl
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws InvalidArgumentException
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function request(string $method, string $uri, array $data = []): mixed
    {
        $key = $this->makeKey($method, $uri, $data);

        if ($this->cache->has($key)) {
            $this->logger->debug("Using cached response $method $uri $key");

            return $this->cache->get($key);
        }

        $result = $this->transport->request($method, $uri, $data);

        $this->cache->set($key, $result, $this->ttl);

        return $result;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function makeKey(string $method, string $uri, array $data): string
    {
        return md5($method.$uri.serialize($data));
    }
}
