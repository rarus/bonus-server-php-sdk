<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Operations;

use Money\Currency;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Util\MoneyParser;

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
            ->setChequeSum(MoneyParser::parseFloat($arResponse['check_sum'], $currency))
            ->setBonusAccrued(MoneyParser::parseFloat($arResponse['bonus_accured'], $currency))
            ->setBonusCanceled(MoneyParser::parseFloat($arResponse['bonus_canceled'], $currency))
            ->setCashRegisterName((string)$arResponse['cashbox'])
            ->setChequeNumber((string)$arResponse['check_number']);

        return $operation;
    }
}
