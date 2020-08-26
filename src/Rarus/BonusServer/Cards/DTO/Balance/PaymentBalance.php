<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Balance;

use Money\Money;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Cards\DTO\Level\LevelId;

/**
 * Class PaymentBalance
 *
 * @package Rarus\BonusServer\Cards\DTO\Balance
 */
final class PaymentBalance
{
    /**
     * @var Money
     */
    private $availableBalance;
    /**
     * @var Money
     */
    private $paymentBalance;
    /**
     * @var LevelId
     */
    private $cardLevelId;
    /**
     * @var CardId
     */
    private $mastercardId;

    /**
     * @return Money
     */
    public function getAvailableBalance(): Money
    {
        return $this->availableBalance;
    }

    /**
     * @param Money $availableBalance
     *
     * @return PaymentBalance
     */
    public function setAvailableBalance(Money $availableBalance): PaymentBalance
    {
        $this->availableBalance = $availableBalance;

        return $this;
    }

    /**
     * @return Money
     */
    public function getPaymentBalance(): Money
    {
        return $this->paymentBalance;
    }

    /**
     * @param Money $paymentBalance
     *
     * @return PaymentBalance
     */
    public function setPaymentBalance(Money $paymentBalance): PaymentBalance
    {
        $this->paymentBalance = $paymentBalance;

        return $this;
    }

    /**
     * @return LevelId
     */
    public function getCardLevelId(): LevelId
    {
        return $this->cardLevelId;
    }

    /**
     * @param LevelId $cardLevelId
     *
     * @return PaymentBalance
     */
    public function setCardLevelId(LevelId $cardLevelId): PaymentBalance
    {
        $this->cardLevelId = $cardLevelId;

        return $this;
    }

    /**
     * @return CardId
     */
    public function getMastercardId(): CardId
    {
        return $this->mastercardId;
    }

    /**
     * @param CardId $mastercardId
     *
     * @return PaymentBalance
     */
    public function setMastercardId(CardId $mastercardId): PaymentBalance
    {
        $this->mastercardId = $mastercardId;

        return $this;
    }
}
