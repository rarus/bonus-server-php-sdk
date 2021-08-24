<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Transactions\DTO\PaymentTypes;


use Money\Money;

/**
 * Class PaymentType
 *
 * @package Rarus\BonusServer\Transactions\DTO\PaymentTypes
 */
class PaymentType
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var \Money\Money
     */
    private $sum;

    /**
     * PaymentType constructor.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param \Money\Money $sum
     */
    public function setSum(Money $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return \Money\Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }
}
