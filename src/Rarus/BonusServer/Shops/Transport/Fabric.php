<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Transport;

use Rarus\BonusServer;

use Psr\Log\LoggerInterface;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Shops
 */
class Fabric
{
    /**
     * @param BonusServer\ApiClient $apiClient
     * @param LoggerInterface       $log
     *
     * @return Transport
     */
    public static function getInstance(BonusServer\ApiClient $apiClient, LoggerInterface $log): Transport
    {
        return new Transport($apiClient, $log);
    }
}


