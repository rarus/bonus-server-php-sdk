<?php

/**
 * Абстрактный класс транспорта.
 * Все транспорты для работы с конкретными сущностями наследуются от него
 */

declare(strict_types=1);

namespace Rarus\LMS\SDK\Transport;

use DateTimeZone;
use Money\Currency;
use Psr\Log\LoggerInterface;
use Rarus\LMS\SDK\Contracts\TransportInterface;

class BaseTransport
{
    public function __construct(
        protected TransportInterface $transport,
        protected LoggerInterface $logger,
        protected Currency $defaultCurrency,
        protected DateTimeZone $dateTimeZone
    ) {}

    protected function getDefaultCurrency(): Currency
    {
        return $this->defaultCurrency;
    }

    protected function getDateTimeZone(): DateTimeZone
    {
        return $this->dateTimeZone;
    }
}
