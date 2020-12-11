<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Coupons\DTO\CouponId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegister;
use Rarus\BonusServer\Transactions\DTO\Document\Document;
use Rarus\BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection;

/**
 * Class Refund
 *
 * @package Rarus\BonusServer\Transactions\DTO
 */
final class Refund extends AbstractTransaction
{
    /**
     * @var Document
     */
    protected $refundDocument;
    /**
     * @var int Количество бонусов, к возврату. Используется при type="refund". Количество возвращаемых бонусов не должно превышать количество начисленных бонусов, иначе счет карты может стать отрицательным.
     */
    protected $refundBonus;

    /**
     * @param CardId $cardId
     *
     * @return Refund
     */
    public function setCardId(CardId $cardId): Refund
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * @param ShopId $shopId
     *
     * @return Refund
     */
    public function setShopId(ShopId $shopId): Refund
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @param Document $document
     *
     * @return Refund
     */
    public function setDocument(Document $document): Refund
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @param CashRegister $cashRegister
     *
     * @return Refund
     */
    public function setCashRegister(CashRegister $cashRegister): Refund
    {
        $this->cashRegister = $cashRegister;

        return $this;
    }

    /**
     * @param string $chequeNumber
     *
     * @return Refund
     */
    public function setChequeNumber(string $chequeNumber): Refund
    {
        $this->chequeNumber = $chequeNumber;

        return $this;
    }

    /**
     * @param string $authorName
     *
     * @return Refund
     */
    public function setAuthorName(string $authorName): Refund
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return Refund
     */
    public function setDescription(string $description): Refund
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Document
     */
    public function getRefundDocument(): Document
    {
        return $this->refundDocument;
    }

    /**
     * @param Document $refundDocument
     *
     * @return Refund
     */
    public function setRefundDocument(Document $refundDocument): Refund
    {
        $this->refundDocument = $refundDocument;

        return $this;
    }

    /**
     * @return int
     */
    public function getRefundBonus(): int
    {
        return $this->refundBonus;
    }

    /**
     * @param int $refundBonus
     *
     * @return Refund
     */
    public function setRefundBonus(int $refundBonus): Refund
    {
        $this->refundBonus = $refundBonus;

        return $this;
    }

    /**
     * @param ChequeRowCollection $chequeRows
     *
     * @return Refund
     */
    public function setChequeRows(ChequeRowCollection $chequeRows): Refund
    {
        $this->chequeRows = $chequeRows;

        return $this;
    }

    /**
     * @param CouponId $couponId
     *
     * @return Refund
     */
    public function setCouponId(CouponId $couponId): Refund
    {
        $this->couponId = $couponId;

        return $this;
    }
}
