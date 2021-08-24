<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use Rarus\BonusServer\Cards\DTO\Card;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection;
use Rarus\BonusServer\Transactions\DTO\PaymentTypes\PaymentTypeCollection;

/**
 * Class Document
 *
 * @package Rarus\BonusServer\Discounts\DTO
 */
final class Document
{
    /**
     * @var Card|null
     */
    private $card;
    /**
     * @var ShopId
     */
    private $shopId;
    /**
     * @var ChequeRowCollection
     */
    private $chequeRows;
    /**
     * @var CouponId|null
     */
    private $couponId;
    /**
     * @var \Rarus\BonusServer\Transactions\DTO\PaymentTypes\PaymentTypeCollection|null
     */
    private $paymentTypeCollection;
    /**
     * @var \Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection|null
     */
    private $certPaymentCollection;

    /**
     * @return null|Card
     */
    public function getCard(): ?Card
    {
        return $this->card;
    }

    /**
     * @param null|Card $card
     *
     * @return Document
     */
    public function setCard(?Card $card): Document
    {
        $this->card = $card;

        return $this;
    }

    /**
     * @return ShopId
     */
    public function getShopId(): ShopId
    {
        return $this->shopId;
    }

    /**
     * @param ShopId $shopId
     *
     * @return Document
     */
    public function setShopId(ShopId $shopId): Document
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return ChequeRowCollection
     */
    public function getChequeRows(): ChequeRowCollection
    {
        return $this->chequeRows;
    }

    /**
     * @param ChequeRowCollection $chequeRows
     *
     * @return Document
     */
    public function setChequeRows(ChequeRowCollection $chequeRows): Document
    {
        $this->chequeRows = $chequeRows;

        return $this;
    }

    /**
     * @return CouponId|null
     */
    public function getCouponId(): ?CouponId
    {
        return $this->couponId;
    }

    /**
     * @param CouponId|null $couponId
     */
    public function setCouponId(?CouponId $couponId): void
    {
        $this->couponId = $couponId;
    }

    /**
     * @return \Rarus\BonusServer\Transactions\DTO\PaymentTypes\PaymentTypeCollection
     */
    public function getPaymentTypeCollection(): ?PaymentTypeCollection
    {
        return $this->paymentTypeCollection;
    }

    /**
     * @param \Rarus\BonusServer\Transactions\DTO\PaymentTypes\PaymentTypeCollection $paymentTypeCollection
     */
    public function setPaymentTypeCollection(
        PaymentTypeCollection $paymentTypeCollection
    ): Document {
        $this->paymentTypeCollection = $paymentTypeCollection;

        return $this;
    }

    /**
     * @return \Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection|null
     */
    public function getCertPaymentCollection(): ?\Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection
    {
        return $this->certPaymentCollection;
    }

    /**
     * @param \Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection|null $certPaymentCollection
     */
    public function setCertPaymentCollection(
        ?\Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection $certPaymentCollection
    ): Document {
        $this->certPaymentCollection = $certPaymentCollection;

        return $this;
    }

}
