<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\FinalScore;

use Money\Money;

/**
 * Class FinalScore
 *
 * @package Rarus\BonusServer\Transactions\DTO\FinalScore
 */
final class FinalScore
{
    /**
     * @var Money
     */
    private $bonusEarned;
    /**
     * @var Money
     */
    private $bonusSpent;
    /**
     * @var Money
     */
    private $cardAccumulationAmount;

    /**
     * @return Money
     */
    public function getBonusEarned(): Money
    {
        return $this->bonusEarned;
    }

    /**
     * @param Money $bonusEarned
     *
     * @return FinalScore
     */
    public function setBonusEarned(Money $bonusEarned): FinalScore
    {
        $this->bonusEarned = $bonusEarned;

        return $this;
    }

    /**
     * @return Money
     */
    public function getBonusSpent(): Money
    {
        return $this->bonusSpent;
    }

    /**
     * @param Money $bonusSpent
     *
     * @return FinalScore
     */
    public function setBonusSpent(Money $bonusSpent): FinalScore
    {
        $this->bonusSpent = $bonusSpent;

        return $this;
    }

    /**
     * @return Money
     */
    public function getCardAccumulationAmount(): Money
    {
        return $this->cardAccumulationAmount;
    }

    /**
     * @param Money $cardAccumulationAmount
     *
     * @return FinalScore
     */
    public function setCardAccumulationAmount(Money $cardAccumulationAmount): FinalScore
    {
        $this->cardAccumulationAmount = $cardAccumulationAmount;

        return $this;
    }
}