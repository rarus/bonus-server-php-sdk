<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\SalesHistory;

use Money\Money;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\Products\ProductRowCollection;
use Rarus\BonusServer\Transactions\DTO\Type\Type;

/**
 * Class HistoryItem
 *
 * @package Rarus\BonusServer\Transactions\DTO\SalesHistory
 */
final class HistoryItem
{
    /**
     * @var int
     */
    private $lineNumber;
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var DocumentId
     */
    private $documentId;
    /**
     * @var CardId
     */
    private $cardId;
    /**
     * @var ShopId
     */
    private $shopId;
    /**
     * @var CashRegisterId
     */
    private $cashRegisterId;
    /**
     * @var ChequeId
     */
    private $chequeId;
    /**
     * @var Money
     */
    private $sum;
    /**
     * @var Money
     */
    private $sumWithDiscount;
    /**
     * @var Type
     */
    private $type;
    /**
     * @var \DateTime
     */
    private $dateCalculate;
    /**
     * @var ProductRowCollection
     */
    private $products;

    /**
     * @return int
     */
    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     *
     * @return HistoryItem
     */
    public function setLineNumber(int $lineNumber): HistoryItem
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return HistoryItem
     */
    public function setDate(\DateTime $date): HistoryItem
    {
        $this->date = $date;

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
     * @return HistoryItem
     */
    public function setDocumentId(DocumentId $documentId): HistoryItem
    {
        $this->documentId = $documentId;

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
     * @return HistoryItem
     */
    public function setCardId(CardId $cardId): HistoryItem
    {
        $this->cardId = $cardId;

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
     * @return HistoryItem
     */
    public function setShopId(ShopId $shopId): HistoryItem
    {
        $this->shopId = $shopId;

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
     * @return HistoryItem
     */
    public function setCashRegisterId(CashRegisterId $cashRegisterId): HistoryItem
    {
        $this->cashRegisterId = $cashRegisterId;

        return $this;
    }

    /**
     * @return ChequeId
     */
    public function getChequeId(): ChequeId
    {
        return $this->chequeId;
    }

    /**
     * @param ChequeId $chequeId
     *
     * @return HistoryItem
     */
    public function setChequeId(ChequeId $chequeId): HistoryItem
    {
        $this->chequeId = $chequeId;

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
     * @return HistoryItem
     */
    public function setSum(Money $sum): HistoryItem
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return Money
     */
    public function getSumWithDiscount(): Money
    {
        return $this->sumWithDiscount;
    }

    /**
     * @param Money $sumWithDiscount
     *
     * @return HistoryItem
     */
    public function setSumWithDiscount(Money $sumWithDiscount): HistoryItem
    {
        $this->sumWithDiscount = $sumWithDiscount;

        return $this;
    }

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
     * @return HistoryItem
     */
    public function setType(Type $type): HistoryItem
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCalculate(): \DateTime
    {
        return $this->dateCalculate;
    }

    /**
     * @param \DateTime $dateCalculate
     *
     * @return HistoryItem
     */
    public function setDateCalculate(\DateTime $dateCalculate): HistoryItem
    {
        $this->dateCalculate = $dateCalculate;

        return $this;
    }

    /**
     * @return ProductRowCollection
     */
    public function getProducts(): ProductRowCollection
    {
        return $this->products;
    }

    /**
     * @param ProductRowCollection $products
     *
     * @return HistoryItem
     */
    public function setProducts(ProductRowCollection $products): HistoryItem
    {
        $this->products = $products;

        return $this;
    }
}
