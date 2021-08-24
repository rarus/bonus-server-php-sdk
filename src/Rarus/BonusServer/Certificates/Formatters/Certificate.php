<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\Formatters;


use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Rarus\BonusServer\Certificates\DTO\CertificateId;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection;
use Rarus\BonusServer\Transactions\Formatters\CertPayment;

/**
 * Class Certificate
 *
 * @package Rarus\BonusServer\Certificates\Formatters
 */
class Certificate
{

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\Certificate $newCertificate
     *
     * @return array
     */
    public static function toArrayForCreateNewCertificate(
        \Rarus\BonusServer\Certificates\DTO\Certificate $newCertificate
    ): array {
        $arFormatted = [];

        if (!empty($newCertificate->getCertificateId()->getId())) {
            $arFormatted['id'] = $newCertificate->getCertificateId()->getId();
        }

        $arFormatted['group_id'] = $newCertificate->getCertificateGroup()->getCertificateGroupId()->getId();

        if (!empty($newCertificate->getDescription())) {
            $arFormatted['description'] = $newCertificate->getDescription();
        }

        if ($newCertificate->getStatus() !== null) {
            $arFormatted['status'] = $newCertificate->getStatus();
        }

        if ($newCertificate->getStatusDescription() !== null) {
            $arFormatted['status_description'] = $newCertificate->getStatusDescription();
        }

        if ($newCertificate->getStatusDate() !== null) {
            $arFormatted['status_date'] = $newCertificate->getStatusDate()->getTimestamp();
        }

        if ($newCertificate->getActivationDate() !== null) {
            $arFormatted['activation_date'] = $newCertificate->getActivationDate()->getTimestamp();
        }

        return $arFormatted;
    }

    /**
     * @param string                                                                 $docId
     * @param \Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection $certPaymentCollection
     *
     * @return array
     */
    public static function toArrayForPay(string $docId, CertPaymentCollection $certPaymentCollection): array
    {
        $arCertPayments = [];

        foreach ($certPaymentCollection as $certPayment) {
            $arCertPayments[] = CertPayment::toArray($certPayment);
        }

        return [
            'doc_id'        => $docId,
            'cert_payments' => $arCertPayments
        ];
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\CertificateId $certificateId
     * @param \Money\Money|null                                 $sum
     * @param string|null                                       $docId
     *
     * @return array
     */
    public static function toArrayForActivate(
        CertificateId $certificateId,
        ?Money $sum,
        ?string $docId
    ): array {
        $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'id'     => $certificateId->getId(),
            'sum'    => $sum ? (float)$decimalFormatter->format($sum) : null,
            'doc_id' => $docId
        ];
    }
}
