<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Transactions\Formatters;


use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

/**
 * Class CertPayment
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class CertPayment
{
    /**
     * @param \Rarus\BonusServer\Transactions\DTO\CertPayments\CertPayment $certPayment
     *
     * @return array
     */
    public static function toArray(\Rarus\BonusServer\Transactions\DTO\CertPayments\CertPayment $certPayment): array
    {
        $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'line_number'    => $certPayment->getLineNumber(),
            'certificate_id' => $certPayment->getCertificateId()->getId(),
            'sum'            => (float)$decimalFormatter->format($certPayment->getSum())
        ];
    }
}
