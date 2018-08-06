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
     * @param Currency $currency
     * @param array    $arAccountStatement
     *
     * @return AccountStatement
     * @throws BonusServer\Exceptions\ApiClientException
     */
    public static function initFromServerResponse(Currency $currency, array $arAccountStatement): AccountStatement
    {
        $trxAmount = new BonusServer\Cards\DTO\TransactionAmount\TransactionAmountCollection();
        foreach ($arAccountStatement['last_transactions'] as $arTrx) {
            $trxAmount->attach(BonusServer\Cards\DTO\TransactionAmount\Fabric::initFromServerResponse($currency, $arTrx));
        }

        $points = new BonusServer\Transactions\DTO\Points\PointCollection();
        foreach ($arAccountStatement['bonusactive'] as $arPoint) {
            $points->attach(BonusServer\Transactions\DTO\Points\Fabric::initPointFromServerResponse($currency, $arPoint));
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