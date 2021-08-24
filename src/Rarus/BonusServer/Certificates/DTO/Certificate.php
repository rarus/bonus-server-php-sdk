<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\DTO;


use Money\Money;

/**
 * Class Certificate
 *
 * @package Rarus\BonusServer\Certificates\DTO
 */
class Certificate
{
    /**
     * @var CertificateId
     */
    private $id;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var int|null
     */
    private $status;

    /**
     * @var \DateTime|null
     */
    private $statusDate;

    /**
     * @var string|null
     */
    private $statusDescription;

    /**
     * @var \DateTime|null
     */
    private $activationDate;

    /**
     * @var int
     */
    private $value;

    /**
     * @var double
     */
    private $nominal;

    /**
     * @var \Money\Money
     */
    private $balance;

    /**
     * @var CertificateGroup
     */
    private $certificateGroup;

    /**
     * @param mixed $description
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param int $status
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param \DateTime $statusDate
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public function setStatusDate(\DateTime $statusDate): self
    {
        $this->statusDate = $statusDate;

        return $this;
    }

    /**
     * @param string $statusDescription
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public function setStatusDescription(string $statusDescription): self
    {
        $this->statusDescription = $statusDescription;

        return $this;
    }

    /**
     * @param \DateTime|null $activationDate
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public function setActivationDate(?\DateTime $activationDate): self
    {
        $this->activationDate = $activationDate;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param float $nominal
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public function setNominal(float $nominal): self
    {
        $this->nominal = $nominal;

        return $this;
    }

    /**
     * @param \Money\Money $balance
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public function setBalance(Money $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @param CertificateGroup $certificateGroup
     */
    public function setCertificateGroup(CertificateGroup $certificateGroup): self
    {
        $this->certificateGroup = $certificateGroup;

        return $this;
    }

    /**
     * Certificate constructor.
     *
     * @param CertificateId $id
     */
    public function __construct(CertificateId $id)
    {
        $this->id = $id;
    }

    /**
     * @return CertificateId
     */
    public function getCertificateId(): CertificateId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return \DateTime|null
     */
    public function getStatusDate(): ?\DateTime
    {
        return $this->statusDate;
    }

    /**
     * @return string
     */
    public function getStatusDescription(): ?string
    {
        return $this->statusDescription;
    }

    /**
     * @return \DateTime|null
     */
    public function getActivationDate(): ?\DateTime
    {
        return $this->activationDate;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return float
     */
    public function getNominal(): float
    {
        return $this->nominal;
    }

    /**
     * @return \Money\Money
     */
    public function getBalance(): Money
    {
        return $this->balance;
    }

    /**
     * @return CertificateGroup
     */
    public function getCertificateGroup(): CertificateGroup
    {
        return $this->certificateGroup;
    }
}
