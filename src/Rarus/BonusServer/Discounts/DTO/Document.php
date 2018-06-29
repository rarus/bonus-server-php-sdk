<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use Rarus\BonusServer\Cards\DTO\Card;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection;

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
}