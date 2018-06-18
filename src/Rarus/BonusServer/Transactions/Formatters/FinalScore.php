<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Formatters;

use Rarus\BonusServer\Transactions;

/**
 * Class FinalScore
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class FinalScore
{
    /**
     * @param Transactions\DTO\FinalScore\FinalScore $finalScore
     *
     * @return array
     */
    public static function toArray(Transactions\DTO\FinalScore\FinalScore $finalScore): array
    {
        return [
            'bonus_earned' => $finalScore->getBonusEarned()->getAmount(),
            'bonus_spent' => $finalScore->getBonusSpent()->getAmount(),
            'card_accum' => $finalScore->getCardAccumulationAmount()->getAmount(),
        ];
    }
}