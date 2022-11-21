<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use Rarus\BonusServer\Cards\DTO\PaymentDistribution\PaymentDistributionCollection;
use Rarus\BonusServer\Discounts\DTO\DiscountItems\DiscountItemCollection;
use Rarus\BonusServer\Discounts\DTO\DocumentItems\DocumentItemCollection;

/**
 * Class Estimate
 *
 * @package Rarus\BonusServer\Discounts\DTO
 */
final class Estimate
{
    /**
     * @var DocumentItemCollection
     */
    private $documentItems;
    /**
     * @var DiscountItemCollection
     */
    private $discountItems;
    /**
     * @var \Rarus\BonusServer\Cards\DTO\PaymentDistribution\PaymentDistributionCollection|null
     */
    private $paymentDistributionCollection;

    /**
     * @var int|null
     */
    private $maxPayment;

    /**
     * @return DiscountItemCollection
     */
    public function getDiscountItems(): DiscountItemCollection
    {
        return $this->discountItems;
    }

    /**
     * @param DiscountItemCollection $discountItems
     *
     * @return Estimate
     */
    public function setDiscountItems(DiscountItemCollection $discountItems): Estimate
    {
        $this->discountItems = $discountItems;

        return $this;
    }

    /**
     * @return DocumentItemCollection
     */
    public function getDocumentItems(): DocumentItemCollection
    {
        return $this->documentItems;
    }

    /**
     * @param DocumentItemCollection $documentItems
     *
     * @return Estimate
     */
    public function setDocumentItems(DocumentItemCollection $documentItems): Estimate
    {
        $this->documentItems = $documentItems;

        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Cards\DTO\PaymentDistribution\PaymentDistributionCollection $paymentDistributionCollection
     *
     * @return Estimate
     */
    public function setPaymentDistributionCollection(
        PaymentDistributionCollection $paymentDistributionCollection
    ): Estimate {
        $this->paymentDistributionCollection = $paymentDistributionCollection;
        return $this;
    }

    /**
     * @return \Rarus\BonusServer\Cards\DTO\PaymentDistribution\PaymentDistributionCollection|null
     */
    public function getPaymentDistributionCollection(): ?PaymentDistributionCollection
    {
        return $this->paymentDistributionCollection;
    }

    /**
     * @param int|null $maxPayment
     *
     * @return Estimate
     */
    public function setMaxPayment(?int $maxPayment): Estimate
    {
        $this->maxPayment = $maxPayment;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxPayment(): ?int
    {
        return $this->maxPayment;
    }
}
