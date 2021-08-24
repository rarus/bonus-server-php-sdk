<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Util;


use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

/**
 * Class MoneyParser
 *
 * @package Rarus\BonusServer\Util
 */
class MoneyParser
{
    /**
     * @param                 $float
     * @param \Money\Currency $currency
     *
     * @return \Money\Money
     */
    public static function parseFloat($float, Currency $currency): Money
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return $moneyParser->parse((string)$float, $currency);
    }
}
