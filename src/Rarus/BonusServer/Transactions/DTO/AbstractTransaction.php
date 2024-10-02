<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\CouponHolds\DTO\CouponHoldId;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Discounts\DTO\DiscountItems\DiscountItemCollection;
use Rarus\BonusServer\Holds\DTO\HoldId;
use Rarus\BonusServer\Holds\DTO\HoldItemCollection;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegister;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection;
use Rarus\BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection;
use Rarus\BonusServer\Transactions\DTO\Document\Document;
use Rarus\BonusServer\Transactions\DTO\PaymentTypes\PaymentTypeCollection;
use Rarus\BonusServer\Transactions\DTO\Type\Type;

/**
 * Class AbstractTransaction
 *
 * @package Rarus\BonusServer\Transactions\DTO
 */
abstract class AbstractTransaction
{
    /**
     * @var string
     */
    protected $chequeNumber;
    /**
     * @var Type
     */
    protected $type;
    /**
     * @var CardId
     */
    protected $cardId;
    /**
     * @var ShopId
     */
    protected $shopId;
    /**
     * @var Document
     */
    protected $document;
    /**
     * @var CashRegister
     */
    protected $cashRegister;
    /**
     * @var string
     */
    protected $authorName;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var ChequeRowCollection
     */
    protected $chequeRows;
    /**
     * @var CouponId
     */
    protected $couponId;

    /**
     * @var CouponHoldId|null
     */
    protected $couponHoldId;
    /**
     * @var DiscountItemCollection|null
     */
    protected $discountItemCollection;
    /**
     * @var PaymentTypeCollection|null
     */
    protected $paymentTypeCollection;
    /**
     * @var CertPaymentCollection|null
     */
    protected $certPaymentCollection;

    /**
     * @var DiscountItemCollection|null
     */
    protected $calculateHistoryCollection;
    /**
     * @var HoldId|null
     */
    protected $holdId;

    /**
     * @var boolean
     */
    protected $holdUsed = true;

    /**
     * @var boolean
     */
    protected $test = false;

    /**
     * @var HoldItemCollection|null
     */
    protected $holdItemCollection;

    /**
     * @return string
     */
    public function getChequeNumber(): string
    {
        return $this->chequeNumber;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return CardId
     */
    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    /**
     * @return ShopId
     */
    public function getShopId(): ShopId
    {
        return $this->shopId;
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * @return CashRegister
     */
    public function getCashRegister(): CashRegister
    {
        return $this->cashRegister;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return ChequeRowCollection
     */
    public function getChequeRows(): ChequeRowCollection
    {
        return $this->chequeRows;
    }

    /**
     * @return CouponId|null
     */
    public function getCouponId(): ?CouponId
    {
        return $this->couponId;
    }

    /**
     * @return DiscountItemCollection|null
     */
    public function getDiscountItemCollection(): ?DiscountItemCollection
    {
        return $this->discountItemCollection;
    }

    /**
     * @param DiscountItemCollection $discountItemCollection
     */
    public function setDiscountItemCollection(DiscountItemCollection $discountItemCollection): AbstractTransaction
    {
        $this->discountItemCollection = $discountItemCollection;
        return $this;
    }
    /**
     * @return PaymentTypeCollection
     */
    public function getPaymentTypeCollection(): ?PaymentTypeCollection
    {
        return $this->paymentTypeCollection;
    }

    /**
     * @param PaymentTypeCollection $paymentTypeCollection
     */
    public function setPaymentTypeCollection(
        PaymentTypeCollection $paymentTypeCollection
    ): void {
        $this->paymentTypeCollection = $paymentTypeCollection;
    }

    /**
     * @return CertPaymentCollection|null
     */
    public function getCertPaymentCollection(): ?CertPaymentCollection
    {
        return $this->certPaymentCollection;
    }

    /**
     * @param CertPaymentCollection|null $certPaymentCollection
     */
    public function setCertPaymentCollection(
        ?CertPaymentCollection $certPaymentCollection
    ): void {
        $this->certPaymentCollection = $certPaymentCollection;
    }

    public function getCalculateHistoryCollection(): ?DiscountItemCollection
    {
        return $this->calculateHistoryCollection;
    }

    public function setCalculateHistoryCollection(?DiscountItemCollection $calculateHistoryCollection
    ): AbstractTransaction {
        $this->calculateHistoryCollection = $calculateHistoryCollection;
        return $this;
    }

    public function getHoldItemCollection(): ?HoldItemCollection
    {
        return $this->holdItemCollection;
    }

    public function setHoldItemCollection(HoldItemCollection $holdItems): AbstractTransaction
    {
        $this->holdItemCollection = $holdItems;
        return $this;
    }

    public function getCouponHoldId(): ?CouponHoldId
    {
        return $this->couponHoldId;
    }

    public function setCouponHoldId(?CouponHoldId $couponHoldId): AbstractTransaction
    {
        $this->couponHoldId = $couponHoldId;
        return $this;
    }
}
