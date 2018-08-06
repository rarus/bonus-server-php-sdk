<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\TransactionAmount;

use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;

use Rarus\BonusServer\Util\DateTimeParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Cards\DTO\TransactionAmount
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $arTransactionAmount
     *
     * @return TransactionAmount
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initFromServerResponse(Currency $currency, array $arTransactionAmount): TransactionAmount
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return (new TransactionAmount())
            ->setTransactionSum($moneyParser->parse((string)$arTransactionAmount['sum'], $currency->getCode()))
            ->setDate(DateTimeParser::parseTimestampFromServerResponse((string)$arTransactionAmount['date']));
    }
}