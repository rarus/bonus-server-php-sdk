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
     * @var string
     */
    private $saleId;
    /**
     * @var string
     */
    private $docId;

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

    public function getSaleId(): string
    {
        return $this->saleId;
    }

    public function setSaleId(string $saleId): FinalScore
    {
        $this->saleId = $saleId;
        return $this;
    }

    public function getDocId(): string
    {
        return $this->docId;
    }

    public function setDocId(string $docId): FinalScore
    {
        $this->docId = $docId;
        return $this;
    }
}
