<?php

/**
 * Абстрактный класс транспорта.
 * Все транспорты для работы с конкретными сущностями наследуются от него
 */

declare(strict_types=1);

namespace Rarus\BonusServer\Transport;

use Psr\Log\LoggerInterface;
use Rarus\BonusServer;
use Money\Currency;

/**
 * Class AbstractTransport
 *
 * @package Rarus\BonusServer
 */
abstract class AbstractTransport
{
    /**
     * @var BonusServer\ApiClient
     */
    protected $apiClient;
    /**
     * @var LoggerInterface
     */
    protected $log;
    /**
     * @var Currency
     */
    private $defaultCurrency;

    /**
     * AbstractTransport constructor.
     *
     * @param BonusServer\ApiClient $apiClient
     * @param Currency              $defaultCurrency
     * @param LoggerInterface       $log
     */
    public function __construct(BonusServer\ApiClient $apiClient, Currency $defaultCurrency, LoggerInterface $log)
    {
        $this->apiClient = $apiClient;
        $this->log = $log;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * @return Currency
     */
    protected function getDefaultCurrency(): Currency
    {
        return $this->defaultCurrency;
    }
}
