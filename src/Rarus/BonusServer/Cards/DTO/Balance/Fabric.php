<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Balance;

use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Cards\DTO\Balance
 */
class Fabric
{
    /**
     * @param array    $arBalanceInfo
     * @param Currency $currency
     *
     * @return Balance
     */
    public static function initFromServerResponse(Currency $currency, array $arBalanceInfo): Balance
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return (new Balance())
            ->setAvailable($moneyParser->parse((string)$arBalanceInfo['balance_available'], $currency->getCode()))
            ->setTotal($moneyParser->parse((string)$arBalanceInfo['balance'], $currency->getCode()));
    }
}