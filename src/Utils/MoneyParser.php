<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Utils;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

/**
 * Class MoneyParser
 */
class MoneyParser
{
    public static function parse(string|int|float $money, Currency $currency): Money
    {
        $decimalMoneyParser = new DecimalMoneyParser(new ISOCurrencies);

        return $decimalMoneyParser->parse((string) $money, $currency);
    }

    public static function toString(Money $money): string
    {
        $isoCurrencies = new ISOCurrencies;
        $decimalMoneyFormatter = new DecimalMoneyFormatter($isoCurrencies);

        return $decimalMoneyFormatter->format($money);
    }
}
