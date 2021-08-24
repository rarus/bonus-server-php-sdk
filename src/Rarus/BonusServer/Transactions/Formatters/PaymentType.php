<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Transactions\Formatters;


use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

/**
 * Class PaymentType
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class PaymentType
{
    /**
     * @param \Rarus\BonusServer\Transactions\DTO\PaymentTypes\PaymentType $paymentType
     *
     * @return array
     */
    public static function toArray(\Rarus\BonusServer\Transactions\DTO\PaymentTypes\PaymentType $paymentType): array
    {
        $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'type' => $paymentType->getCode(),
            'sum'  => (float)$decimalFormatter->format($paymentType->getSum())
        ];
    }
}
