<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use Rarus\BonusServer\Cards\DTO\Card;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Holds\DTO\HoldId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection;
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
     * @var int|null
     */
    private $bonusPayment;

    /**
     * @var HoldId|null
     */
    private $holdId;

    /**
     * @var boolean
     */
    protected $holdUsed = false;

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
    public function getCertPaymentCollection(): ?CertPaymentCollection
    {
        return $this->certPaymentCollection;
    }

    /**
     * @param \Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection|null $certPaymentCollection
     *
     * @return \Rarus\BonusServer\Discounts\DTO\Document
     */
    public function setCertPaymentCollection(
        ?CertPaymentCollection $certPaymentCollection
    ): Document {
        $this->certPaymentCollection = $certPaymentCollection;

        return $this;
    }

    /**
     * @param int|null $bonusPayment
     *
     * @return Document
     */
    public function setBonusPayment(?int $bonusPayment): Document
    {
        $this->bonusPayment = $bonusPayment;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getBonusPayment(): ?int
    {
        return $this->bonusPayment;
    }

    public function getHoldId(): ?HoldId
    {
        return $this->holdId;
    }

    public function setHoldId(?HoldId $holdId): Document
    {
        $this->holdId = $holdId;
        return $this;
    }

    public function isHoldUsed(): bool
    {
        return $this->holdUsed;
    }

    public function setHoldUsed(bool $holdUsed): Document
    {
        $this->holdUsed = $holdUsed;
        return $this;
    }
}
