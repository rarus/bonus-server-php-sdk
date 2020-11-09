<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Transactions\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegister;
use Rarus\BonusServer\Transactions\DTO\Document\Document;
use Rarus\BonusServer\Transactions\DTO\Type\Type;

/**
 * Class Manual
 *
 * @package Rarus\BonusServer\Transactions\DTO
 */
final class Manual
{
    /**
     * @var CardId
     */
    private $cardId;
    /**
     * @var \DateTime
     */
    private $time;
    /**
     * @var Type
     */
    private $type;
    /**
     * @var int
     */
    private $sum;
    /**
     * @var string
     */
    private $authorName;
    /**
     * @var string|null
     */
    private $description;
    /**
     * @var Document
     */
    private $document;
    /**
     * Идентификатор документа во внешней системе
     *
     * @var CashRegister|null
     */
    private $cashRegister;
    /**
     * @var ShopId
     */
    private $shopId;
    /**
     * [Необязательный]. Идентификатор скидки, если транзакция выполняется для отложенного начисления/списания по акции
     *
     * @var DiscountId|null
     */
    private $discountId;
    /**
     * [Необязательный]. Признак проверки активности. Если настроено ограничение на количество операций в течение
     * суток, при установленном признаке транзакция будет расцениваться как активность по карте и увеличит счетчик
     * операций. При достижении ограничения - метод вернет ошибку
     *
     * @var bool|null
     */
    private $checkActivityCounter;
    /**
     * [Необязательный]. Дней до сгорания баллов. Если не передан берется из настроек организации
     *
     * @var int|null
     */
    private $invalidatePeriod;
    /**
     * [Необязательный]. Дней до активации баллов. Если не передан берется из настроек организации
     *
     * @var int|null;
     */
    private $activationPeriod;
    /**
     * [Необязательный]. Базовая дата от которой будет считаться дней до активации
     *
     * @var \DateTime|null
     */
    private $activationBaseDate;
    /**
     * [Необязательный]. Базовая дата от которой будет считаться дней до сгорания
     *
     * @var \DateTime|null
     */
    private $invalidateBaseDate;

    /**
     * Manual constructor.
     *
     * @param CardId $cardId
     * @param \DateTime $time
     * @param Type $type
     * @param int $sum
     * @param string $author
     * @param Document $document
     * @param ShopId $shopId
     */
    public function __construct(
        CardId $cardId,
        \DateTime $time,
        Type $type,
        int $sum,
        string $author,
        Document $document,
        ShopId $shopId
    ) {
        $this->cardId = $cardId;
        $this->time = $time;
        $this->type = $type;
        $this->sum = $sum;
        $this->authorName = $author;
        $this->document = $document;
        $this->shopId = $shopId;
    }

    /**
     * @param CashRegister|null $cashRegister
     */
    public function setCashRegister(?CashRegister $cashRegister): void
    {
        $this->cashRegister = $cashRegister;
    }

    /**
     * @param DiscountId|null $discountId
     */
    public function setDiscountId(?DiscountId $discountId): void
    {
        $this->discountId = $discountId;
    }

    /**
     * @param bool|null $checkActivityCounter
     */
    public function setCheckActivityCounter(?bool $checkActivityCounter): void
    {
        $this->checkActivityCounter = $checkActivityCounter;
    }

    /**
     * @param int|null $invalidatePeriod
     */
    public function setInvalidatePeriod(?int $invalidatePeriod): void
    {
        $this->invalidatePeriod = $invalidatePeriod;
    }

    /**
     * @param int|null $activationPeriod
     */
    public function setActivationPeriod(?int $activationPeriod): void
    {
        $this->activationPeriod = $activationPeriod;
    }

    /**
     * @param \DateTime|null $activationBaseDate
     */
    public function setActivationBaseDate(?\DateTime $activationBaseDate): void
    {
        $this->activationBaseDate = $activationBaseDate;
    }

    /**
     * @param \DateTime|null $invalidateBaseDate
     */
    public function setInvalidateBaseDate(?\DateTime $invalidateBaseDate): void
    {
        $this->invalidateBaseDate = $invalidateBaseDate;
    }

    /**
     * @return CardId
     */
    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * @return CashRegister|null
     */
    public function getCashRegister(): ?CashRegister
    {
        return $this->cashRegister;
    }

    /**
     * @return ShopId
     */
    public function getShopId(): ShopId
    {
        return $this->shopId;
    }

    /**
     * @return DiscountId|null
     */
    public function getDiscountId(): ?DiscountId
    {
        return $this->discountId;
    }

    /**
     * @return bool|null
     */
    public function getCheckActivityCounter(): ?bool
    {
        return $this->checkActivityCounter;
    }

    /**
     * @return int|null
     */
    public function getInvalidatePeriod(): ?int
    {
        return $this->invalidatePeriod;
    }

    /**
     * @return int|null
     */
    public function getActivationPeriod(): ?int
    {
        return $this->activationPeriod;
    }

    /**
     * @return \DateTime|null
     */
    public function getActivationBaseDate(): ?\DateTime
    {
        return $this->activationBaseDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getInvalidateBaseDate(): ?\DateTime
    {
        return $this->invalidateBaseDate;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

}
