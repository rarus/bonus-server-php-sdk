<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\FinalScore;

use Money\Currency;
use Money\Money;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\FinalScore
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $arResponse
     *
     * @return FinalScore
     */
    public static function initFinalScoreFromServerResponse(Currency $currency, array $arResponse): FinalScore
    {
        $score = new FinalScore();

        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        $score
            ->setBonusEarned($moneyParser->parse((string)$arResponse['bonus_earned'], $currency))
            ->setBonusSpent($moneyParser->parse((string)$arResponse['bonus_spent'], $currency))
            ->setSaleId((string)$arResponse['sale_id'])
            ->setDocId((string)$arResponse['doc_id'])
            ->setCardAccumulationAmount($moneyParser->parse((string)$arResponse['card_accum'], $currency));

        return $score;
    }
}
