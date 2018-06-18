<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Operations;

use Money\Currency;
use Money\Money;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Operations
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $arResponse
     *
     * @return Operation
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initFinalScoreFromServerResponse(Currency $currency, array $arResponse): Operation
    {
        $operationDate = new \DateTime();
        $operationDate->setTimestamp((int)$arResponse['date']);

        $operation = new Operation();
        $operation
            ->setId($arResponse['id'])
            ->setDate($operationDate)
            ->setType(Transactions\DTO\Type\Fabric::initFromServerResponse($arResponse['operation']))
            ->setShopId(new ShopId($arResponse['shop_id']))
            ->setShopName((string)$arResponse['shop_name'])
            ->setShopAddress((string)$arResponse['shop_address'])
            ->setChequeSum(new Money($arResponse['check_sum'], $currency))
            ->setBonusAccrued(new Money($arResponse['bonus_accured'], $currency))
            ->setBonusCanceled(new Money($arResponse['bonus_canceled'], $currency))
            ->setCashRegisterName((string)$arResponse['cashbox'])
            ->setChequeNumber((string)$arResponse['check_number']);

        return $operation;
    }
}