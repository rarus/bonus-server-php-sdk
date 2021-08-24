<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Transactions\DTO\PaymentTypes;


use Rarus\BonusServer\Exceptions\ApiClientException;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\PaymentTypes
 */
class Fabric
{
    /**
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initFromServerResponse(string $code): PaymentType
    {
        switch (strtolower($code)) {
            case 'cash':
                return self::getCash();
                break;
            case 'card':
                return self::getCard();
                break;
            case 'certificate':
                return self::getCertificate();
                break;
            default:
                throw  new ApiClientException(sprintf('unknown operation code [%s]', $code));
                break;
        }
    }

    public static function getCash(): PaymentType
    {
        return new PaymentType('cash');
    }

    public static function getCard(): PaymentType
    {
        return new PaymentType('card');
    }

    public static function getCertificate(): PaymentType
    {
        return new PaymentType('certificate');
    }
}
