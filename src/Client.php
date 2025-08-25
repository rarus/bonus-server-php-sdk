<?php

declare(strict_types=1);

namespace RarusBonus;

use Money\Currency;
use Psr\Log\LoggerInterface;
use RarusBonus\Auth\AuthTransport;
use RarusBonus\Cards\Transport\CardsTransport;
use RarusBonus\Transport\HttpTransport;
use RarusBonus\Users\Transport\UsersTransport;

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
