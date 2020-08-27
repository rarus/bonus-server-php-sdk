<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Operations;

use Money\Money;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\Type\Type;

/**
 * Class Operation
 *
 * @package Rarus\BonusServer\Transactions\DTO\Operations
 */
final class Operation
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var Type
     */
    private $type;
    /**
     * @var ShopId
     */
    private $shopId;
    /**
     * @var string
     */
    private $shopName;
    /**
     * @var string
     */
    private $shopAddress;
    /**
     * @var Money
     */
    private $chequeSum;
    /**
     * @var Money
     */
    private $bonusAccrued;
    /**
     * @var Money
     */
    private $bonusCanceled;
    /**
     * @var string
     */
    private $cashRegisterName;
    /**
     * @var string
     */
    private $chequeNumber;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Operation
     */
    public function setId(string $id): Operation
    {
        $this->id = $id;

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
     * @return Operation
     */
    public function setDate(\DateTime $date): Operation
    {
        $this->date = $date;

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
     * @return Operation
     */
    public function setType(Type $type): Operation
    {
        $this->type = $type;

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
     * @return Operation
     */
    public function setShopId(ShopId $shopId): Operation
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopName(): string
    {
        return $this->shopName;
    }

    /**
     * @param string $shopName
     *
     * @return Operation
     */
    public function setShopName(string $shopName): Operation
    {
        $this->shopName = $shopName;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopAddress(): string
    {
        return $this->shopAddress;
    }

    /**
     * @param string $shopAddress
     *
     * @return Operation
     */
    public function setShopAddress(string $shopAddress): Operation
    {
        $this->shopAddress = $shopAddress;

        return $this;
    }

    /**
     * @return Money
     */
    public function getChequeSum(): Money
    {
        return $this->chequeSum;
    }

    /**
     * @param Money $chequeSum
     *
     * @return Operation
     */
    public function setChequeSum(Money $chequeSum): Operation
    {
        $this->chequeSum = $chequeSum;

        return $this;
    }

    /**
     * @return Money
     */
    public function getBonusAccrued(): Money
    {
        return $this->bonusAccrued;
    }

    /**
     * @param Money $bonusAccrued
     *
     * @return Operation
     */
    public function setBonusAccrued(Money $bonusAccrued): Operation
    {
        $this->bonusAccrued = $bonusAccrued;

        return $this;
    }

    /**
     * @return Money
     */
    public function getBonusCanceled(): Money
    {
        return $this->bonusCanceled;
    }

    /**
     * @param Money $bonusCanceled
     *
     * @return Operation
     */
    public function setBonusCanceled(Money $bonusCanceled): Operation
    {
        $this->bonusCanceled = $bonusCanceled;

        return $this;
    }

    /**
     * @return string
     */
    public function getCashRegisterName(): string
    {
        return $this->cashRegisterName;
    }

    /**
     * @param string $cashRegisterName
     *
     * @return Operation
     */
    public function setCashRegisterName(string $cashRegisterName): Operation
    {
        $this->cashRegisterName = $cashRegisterName;

        return $this;
    }

    /**
     * @return string
     */
    public function getChequeNumber(): string
    {
        return $this->chequeNumber;
    }

    /**
     * @param string $chequeNumber
     *
     * @return Operation
     */
    public function setChequeNumber(string $chequeNumber): Operation
    {
        $this->chequeNumber = $chequeNumber;

        return $this;
    }
}
