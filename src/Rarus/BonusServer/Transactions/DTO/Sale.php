<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection;
use Rarus\BonusServer\Transactions\DTO\Document\Document;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegister;
use Rarus\BonusServer\Transactions\DTO\Type\Type;

/**
 * Class Sale
 *
 * @package Rarus\BonusServer\Transactions\DTO
 */
final class Sale extends AbstractTransaction
{
    /**
     * @var int Количество бонусов списываемое в счет оплаты чека. Если карта частично заблокирована, заблокирована или неактивна - значение не должно передаваться или должно быть  = 0, в противном случае сервис возвращает ошибку.
     */
    protected $bonusPayment;

    /**
     * @param string $chequeNumber
     *
     * @return Sale
     */
    public function setChequeNumber(string $chequeNumber): Sale
    {
        $this->chequeNumber = $chequeNumber;

        return $this;
    }

    /**
     * @param Type $type
     *
     * @return Sale
     */
    public function setType(Type $type): Sale
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param CardId $cardId
     *
     * @return Sale
     */
    public function setCardId(CardId $cardId): Sale
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * @param ShopId $shopId
     *
     * @return Sale
     */
    public function setShopId(ShopId $shopId): Sale
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @param Document $document
     *
     * @return Sale
     */
    public function setDocument(Document $document): Sale
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @param CashRegister $cashRegister
     *
     * @return Sale
     */
    public function setCashRegister(CashRegister $cashRegister): Sale
    {
        $this->cashRegister = $cashRegister;

        return $this;
    }

    /**
     * @param string $authorName
     *
     * @return Sale
     */
    public function setAuthorName(string $authorName): Sale
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return Sale
     */
    public function setDescription(string $description): Sale
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param ChequeRowCollection $chequeRows
     *
     * @return Sale
     */
    public function setChequeRows(ChequeRowCollection $chequeRows): Sale
    {
        $this->chequeRows = $chequeRows;

        return $this;
    }

    /**
     * @return int
     */
    public function getBonusPayment(): int
    {
        return $this->bonusPayment;
    }

    /**
     * @param int $bonusPayment
     *
     * @return Sale
     */
    public function setBonusPayment(int $bonusPayment): Sale
    {
        $this->bonusPayment = $bonusPayment;

        return $this;
    }
}