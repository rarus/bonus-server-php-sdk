<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK;

use Money\Currency;
use Psr\Log\LoggerInterface;
use Rarus\LMS\SDK\Auth\AuthTransport;
use Rarus\LMS\SDK\Cards\Transport\CardsTransport;
use Rarus\LMS\SDK\Transport\HttpTransport;
use Rarus\LMS\SDK\Users\Transport\UsersTransport;

final readonly class Client
{
    public function __construct(
        private HttpTransport $transport,
        private LoggerInterface $logger,
        private Currency $currency,
        private \DateTimeZone $timeZone,
    ) {}

    public function auth(): AuthTransport
    {
        return new AuthTransport($this->transport, $this->logger, $this->currency, $this->timeZone);
    }

    public function transport(): HttpTransport
    {
        return $this->transport;
    }

    public function users(): UsersTransport
    {
        return new UsersTransport($this->transport, $this->logger, $this->currency, $this->timeZone);
    }

    public function cards(): CardsTransport
    {
        return new CardsTransport($this->transport, $this->logger, $this->currency, $this->timeZone);
    }
}
