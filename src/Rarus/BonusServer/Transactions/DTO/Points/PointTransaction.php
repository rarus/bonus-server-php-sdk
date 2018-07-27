<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points;

use Money\Money;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\Type\Type;

/**
 * объект с информацией о начислении или списании баллов с карты
 *
 * Class PointTransaction
 *
 * @package Rarus\BonusServer\Transactions\DTO\Points
 */
class PointTransaction
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
     * @return PointTransaction
     */
    public function setType(Type $type): PointTransaction
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
     * @return PointTransaction
     */
    public function setRowNumber(int $rowNumber): PointTransaction
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
     * @return PointTransaction
     */
    public function setPointId(PointId $pointId): PointTransaction
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
     * @return PointTransaction
     */
    public function setCardId(CardId $cardId): PointTransaction
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
     * @return PointTransaction
     */
    public function setMastercardId(CardId $mastercardId): PointTransaction
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
     * @return PointTransaction
     */
    public function setTime(\DateTime $time): PointTransaction
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
     * @return PointTransaction
     */
    public function setSum(Money $sum): PointTransaction
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
     * @return PointTransaction
     */
    public function setAuthor(string $author): PointTransaction
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
     * @return PointTransaction
     */
    public function setDescription(string $description): PointTransaction
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
     * @return PointTransaction
     */
    public function setDocumentId(DocumentId $documentId): PointTransaction
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
     * @return PointTransaction
     */
    public function setCashRegisterId(CashRegisterId $cashRegisterId): PointTransaction
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
     * @return PointTransaction
     */
    public function setShopId(ShopId $shopId): PointTransaction
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
     * @return PointTransaction
     */
    public function setDocumentTypeId(string $documentTypeId): PointTransaction
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
     * @return PointTransaction
     */
    public function setInvalidatePeriod(\DateTime $invalidatePeriod): PointTransaction
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
     * @return PointTransaction
     */
    public function setActivationPeriod(\DateTime $activationPeriod): PointTransaction
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
     * @return PointTransaction
     */
    public function setDiscountId(DiscountId $discountId): PointTransaction
    {
        $this->discountId = $discountId;

        return $this;
    }
}