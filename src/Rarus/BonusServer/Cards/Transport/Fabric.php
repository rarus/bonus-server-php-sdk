<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport;

use Rarus\BonusServer;

use Psr\Log\LoggerInterface;

use Money\Currency;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Cards
 */
class Fabric
{
    /**
     * @param BonusServer\ApiClient $apiClient
     * @param Currency              $defaultCurrency
     * @param LoggerInterface       $log
     *
     * @return Transport
     */
    public static function getInstance(BonusServer\ApiClient $apiClient, Currency $defaultCurrency, LoggerInterface $log): Transport
    {
        return new Transport($apiClient, $defaultCurrency, $log);
    }
}