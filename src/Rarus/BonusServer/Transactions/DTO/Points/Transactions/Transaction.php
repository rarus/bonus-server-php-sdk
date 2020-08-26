<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points\Transactions;

use Money\Money;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\Type\Type;
use Rarus\BonusServer\Transactions\DTO\Points\PointId;

/**
 * объект с информацией о начислении или списании баллов с карты
 *
 * Class PointTransaction
 *
 * @package Rarus\BonusServer\Transactions\DTO\Points
 */
class Transaction
{
    /**
     * @var int
     */
    private $rowNumber;
    /**
     * @var PointId
     */
    private $pointId;
    /**
     * @var CardId
     */
    private $cardId;
    /**
     * @var CardId
     */
    private $mastercardId;
    /**
     * @var \DateTime
     */
    private $time;
    /**
     * @var Money
     */
    private $sum;
    /**
     * @var Type
     */
    private $type;
    /**
     * @var string
     */
    private $author;
    /**
     * @var string
     */
    private $description;
    /**
     * @var DocumentId
     */
    private $documentId;
    /**
     * @var CashRegisterId
     */
    private $cashRegisterId;
    /**
     * @var ShopId
     */
    private $shopId;
    /**
     * @var string
     */
    private $documentTypeId;
    /**
     * @var \DateTime
     */
    private $invalidatePeriod;
    /**
     * @var \DateTime
     */
    private $activationPeriod;
    /**
     * @var DiscountId
     */
    private $discountId;

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     *
     * @return Transaction
     */
    public function setType(Type $type): Transaction
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }

    /**
     * @param int $rowNumber
     *
     * @return Transaction
     */
    public function setRowNumber(int $rowNumber): Transaction
    {
        $this->rowNumber = $rowNumber;

        return $this;
    }

    /**
     * @return PointId
     */
    public function getPointId(): PointId
    {
        return $this->pointId;
    }

    /**
     * @param PointId $pointId
     *
     * @return Transaction
     */
    public function setPointId(PointId $pointId): Transaction
    {
        $this->pointId = $pointId;

        return $this;
    }

    /**
     * @return CardId
     */
    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    /**
     * @param CardId $cardId
     *
     * @return Transaction
     */
    public function setCardId(CardId $cardId): Transaction
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * @return CardId
     */
    public function getMastercardId(): CardId
    {
        return $this->mastercardId;
    }

    /**
     * @param CardId $mastercardId
     *
     * @return Transaction
     */
    public function setMastercardId(CardId $mastercardId): Transaction
    {
        $this->mastercardId = $mastercardId;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     *
     * @return Transaction
     */
    public function setTime(\DateTime $time): Transaction
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }

    /**
     * @param Money $sum
     *
     * @return Transaction
     */
    public function setSum(Money $sum): Transaction
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     *
     * @return Transaction
     */
    public function setAuthor(string $author): Transaction
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Transaction
     */
    public function setDescription(string $description): Transaction
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return DocumentId
     */
    public function getDocumentId(): DocumentId
    {
        return $this->documentId;
    }

    /**
     * @param DocumentId $documentId
     *
     * @return Transaction
     */
    public function setDocumentId(DocumentId $documentId): Transaction
    {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * @return CashRegisterId
     */
    public function getCashRegisterId(): CashRegisterId
    {
        return $this->cashRegisterId;
    }

    /**
     * @param CashRegisterId $cashRegisterId
     *
     * @return Transaction
     */
    public function setCashRegisterId(CashRegisterId $cashRegisterId): Transaction
    {
        $this->cashRegisterId = $cashRegisterId;

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
     * @return Transaction
     */
    public function setShopId(ShopId $shopId): Transaction
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentTypeId(): string
    {
        return $this->documentTypeId;
    }

    /**
     * @param string $documentTypeId
     *
     * @return Transaction
     */
    public function setDocumentTypeId(string $documentTypeId): Transaction
    {
        $this->documentTypeId = $documentTypeId;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInvalidatePeriod(): \DateTime
    {
        return $this->invalidatePeriod;
    }

    /**
     * @param \DateTime $invalidatePeriod
     *
     * @return Transaction
     */
    public function setInvalidatePeriod(\DateTime $invalidatePeriod): Transaction
    {
        $this->invalidatePeriod = $invalidatePeriod;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getActivationPeriod(): \DateTime
    {
        return $this->activationPeriod;
    }

    /**
     * @param \DateTime $activationPeriod
     *
     * @return Transaction
     */
    public function setActivationPeriod(\DateTime $activationPeriod): Transaction
    {
        $this->activationPeriod = $activationPeriod;

        return $this;
    }

    /**
     * @return DiscountId
     */
    public function getDiscountId(): DiscountId
    {
        return $this->discountId;
    }

    /**
     * @param DiscountId $discountId
     *
     * @return Transaction
     */
    public function setDiscountId(DiscountId $discountId): Transaction
    {
        $this->discountId = $discountId;

        return $this;
    }
}
