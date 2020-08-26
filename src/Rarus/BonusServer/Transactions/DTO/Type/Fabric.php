<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Type;

use Rarus\BonusServer\Exceptions\ApiClientException;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Type
 */
class Fabric
{
    /**
     * @param string $operationCode
     *
     * @return Type
     * @throws ApiClientException
     */
    public static function initFromServerResponse(string $operationCode): Type
    {
        switch (strtolower($operationCode)) {
            case 'sale':
                return self::getSale();
                break;
            case 'refund':
                return self::getRefund();
                break;
            default:
                throw  new ApiClientException(sprintf('unknown operation code [%s]', $operationCode));
                break;
        }
    }

    /**
     * @return Type
     */
    public static function getSale(): Type
    {
        return new Type('sale');
    }

    /**
     * @return Type
     */
    public static function getRefund(): Type
    {
        return new Type('refund');
    }
}
