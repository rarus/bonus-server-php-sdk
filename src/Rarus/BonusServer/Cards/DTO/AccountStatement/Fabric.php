<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\AccountStatement;

use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;
use Rarus\BonusServer;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Cards\DTO\Balance
 */
class Fabric
{
    /**
     * @param Currency      $currency
     * @param array         $arAccountStatement
     * @param \DateTimeZone $dateTimeZone
     *
     * @return AccountStatement
     * @throws BonusServer\Exceptions\ApiClientException
     */
    public static function initFromServerResponse(Currency $currency, array $arAccountStatement, \DateTimeZone $dateTimeZone): AccountStatement
    {
        $trxAmount = new BonusServer\Cards\DTO\TransactionAmount\TransactionAmountCollection();
        if (key_exists('last_transactions', $arAccountStatement)) {
            foreach ((array)$arAccountStatement['last_transactions'] as $arTrx) {
                $trxAmount->attach(BonusServer\Cards\DTO\TransactionAmount\Fabric::initFromServerResponse(
                    $currency,
                    $arTrx,
                    $dateTimeZone
                ));
            }
        }

        $points = new BonusServer\Transactions\DTO\Points\PointCollection();
        if (key_exists('bonusactive', $arAccountStatement)) {
            foreach ((array)$arAccountStatement['bonusactive'] as $arPoint) {
                $points->attach(BonusServer\Transactions\DTO\Points\Fabric::initPointFromServerResponse(
                    $currency,
                    $arPoint,
                    $dateTimeZone
                ));
            }
        }
        $points->rewind();

        $accountStatement = new AccountStatement();
        $accountStatement
            ->setBalance(BonusServer\Cards\DTO\Balance\Fabric::initFromServerResponse($currency, $arAccountStatement))
            ->setTransactions($trxAmount)
            ->setPoints($points);

        return $accountStatement;
    }
}
