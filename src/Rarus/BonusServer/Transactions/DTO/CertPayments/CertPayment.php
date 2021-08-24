<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Transactions\DTO\CertPayments;


/**
 * Class CertPayment
 *
 * @package Rarus\BonusServer\Transactions\DTO\CertPayments
 */
class CertPayment
{
    /**
     * @var int
     */
    private $lineNumber;
    /**
     * @var \Rarus\BonusServer\Certificates\DTO\CertificateId
     */
    private $certificateId;
    /**
     * @var \Money\Money
     */
    private $sum;

    /**
     * @return int
     */
    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     */
    public function setLineNumber(int $lineNumber): self
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    /**
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateId
     */
    public function getCertificateId(): \Rarus\BonusServer\Certificates\DTO\CertificateId
    {
        return $this->certificateId;
    }

    /**
     * @param \Rarus\BonusServer\Certificates\DTO\CertificateId $certificateId
     */
    public function setCertificateId(\Rarus\BonusServer\Certificates\DTO\CertificateId $certificateId): self
    {
        $this->certificateId = $certificateId;

        return $this;
    }

    /**
     * @return \Money\Money
     */
    public function getSum(): \Money\Money
    {
        return $this->sum;
    }

    /**
     * @param \Money\Money $sum
     */
    public function setSum(\Money\Money $sum): self
    {
        $this->sum = $sum;

        return $this;
    }
}
