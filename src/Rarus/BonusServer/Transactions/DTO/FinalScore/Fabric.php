<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\FinalScore;

use Money\Currency;
use Money\Money;

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

        $score
            ->setBonusEarned(new Money($arResponse['bonus_earned'], $currency))
            ->setBonusSpent(new Money($arResponse['bonus_spent'], $currency))
            ->setCardAccumulationAmount(new Money($arResponse['card_accum'], $currency));

        return $score;
    }
}