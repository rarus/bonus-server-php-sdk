<?php
/**
 * Абстрактный класс транспорта.
 * Все транспорты для работы с конкретными сущностями наследуются от него
 */
declare(strict_types=1);

namespace Rarus\BonusServer\Transport;

use Psr\Log\LoggerInterface;
use Rarus\BonusServer;

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
     * AbstractTransport constructor.
     *
     * @param \Rarus\BonusServer\ApiClient $apiClient
     * @param \Psr\Log\LoggerInterface     $log
     */
    public function __construct(BonusServer\ApiClient $apiClient, LoggerInterface $log)
    {
        $this->apiClient = $apiClient;
        $this->log = $log;
    }
}