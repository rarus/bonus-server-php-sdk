<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Coupons\Transport\Role\Organization;

use Rarus\BonusServer;
use Psr\Log\LoggerInterface;
use Money\Currency;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Coupons
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
