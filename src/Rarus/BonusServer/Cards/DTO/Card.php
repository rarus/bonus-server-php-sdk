<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO;

use Money\Money;
use Rarus\BonusServer\Cards\DTO\Barcode\Barcode;
use Rarus\BonusServer\Cards\DTO\Level\LevelId;
use Rarus\BonusServer\Cards\DTO\Status\CardStatus;
use Rarus\BonusServer\Users\DTO\UserId;

/**
 * Class Card
 *
 * @package Rarus\BonusServer\Card\DTO
 */
final class Card
{
    /**
     * @var CardId Идентификатор карты. Если не передан - генерируется сервисом.
     */
    private $cardId;
    /**
     * @var CardId Идентификатор родительской группы. Если не передан - карта создается в корне дерева карт
     */
    private $parentId;
    /**
     * @var string Магнитный код карты
     */
    private $code;
    /**
     * @var Barcode
     */
    private $barcode;
    /**
     * @var string Наименование карты
     */
    private $name;
    /**
     * @var string Дополнительное описание карты
     */
    private $description;
    /**
     * @var \DateTime|null Дата последней транзакции по карте
     */
    private $dateLastTransaction;
    /**
     * @var string|null Идентификатор последней транзакции
     */
    private $lastTransaction;
    /**
     * идентификатор мастер-карты. Если указан, все начисления и списания бонусов будут проходить по мастер-карте.
     * Используется как общий счет для нескольких карт
     *
     * @var string
     */
    private $mastercardId;
    /**
     * Идентификатор карты участнка, который пригласил держателя текущей карты в программу лояльности(реферал).
     * Используется для расчета некоторых видов скидок
     *
     * @var string
     */
    private $referralLinkId;
    /**
     * @var \DateTime Дата первой покупки
     *
     */
    private $dateFirstCheck;
    /**
     * @var UserId|null
     */
    private $userId;
    /**
     * 0 - наша карта, иначе - сторонняя. Сторонние карты не могут быть привязаны к учетным записям пользователей.
     * Может использоваться для учета карт других систем лояльности и применения скидок к ним.
     *
     * @var bool
     */
    private $isExternalCard;
    /**
     * @var Money Оборот накоплений по продажам на карте(не бонусны).
     */
    private $accumSaleAmount;
    /**
     * @var LevelId|null Уровень карты. Используется при расчете скидок.
     */
    private $cardLevelId;

    /**
     * @var string Идентификатор магазина в котором была активирована карта.
     */
    private $activationShopId;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $externalCardId;
    /**
     * @var string URI картинки карты. По-умолчанию берется из настроек организации.
     */
    private $imageUri;
    /**
     * @var CardStatus
     */
    private $cardStatus;

    /**
     * @return LevelId|null
     */
    public function getCardLevelId(): ?LevelId
    {
        return $this->cardLevelId;
    }

    /**
     * @param LevelId $cardLevelId
     *
     * @return Card
     */
    public function setCardLevelId(LevelId $cardLevelId): Card
    {
        $this->cardLevelId = $cardLevelId;

        return $this;
    }

    /**
     * @return null|UserId
     */
    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    /**
     * @param null|UserId $userId
     *
     * @return Card
     */
    public function setUserId(?UserId $userId): Card
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return CardStatus
     */
    public function getCardStatus(): CardStatus
    {
        return $this->cardStatus;
    }

    /**
     * @param CardStatus $cardStatus
     *
     * @return Card
     */
    public function setCardStatus(CardStatus $cardStatus): Card
    {
        $this->cardStatus = $cardStatus;

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
     * @return Card
     */
    public function setCardId(CardId $cardId): Card
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * @return CardId|null
     */
    public function getParentId(): ?CardId
    {
        return $this->parentId;
    }

    /**
     * @param CardId $parentId
     *
     * @return Card
     */
    public function setParentId(CardId $parentId): Card
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Card
     */
    public function setCode(string $code): Card
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Barcode
     */
    public function getBarcode(): Barcode
    {
        return $this->barcode;
    }

    /**
     * @param Barcode $barcode
     *
     * @return Card
     */
    public function setBarcode(Barcode $barcode): Card
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Card
     */
    public function setName(string $name): Card
    {
        $this->name = $name;

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
     * @return Card
     */
    public function setDescription(string $description): Card
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateLastTransaction(): ?\DateTime
    {
        return $this->dateLastTransaction;
    }

    /**
     * @param \DateTime|null $dateLastTransaction
     *
     * @return Card
     */
    public function setDateLastTransaction(?\DateTime $dateLastTransaction): Card
    {
        $this->dateLastTransaction = $dateLastTransaction;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastTransaction(): ?string
    {
        return $this->lastTransaction;
    }

    /**
     * @param null|string $lastTransaction
     *
     * @return Card
     */
    public function setLastTransaction(?string $lastTransaction): Card
    {
        $this->lastTransaction = $lastTransaction;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMastercardId(): ?string
    {
        return $this->mastercardId;
    }

    /**
     * @param string $mastercardId
     *
     * @return Card
     */
    public function setMastercardId(string $mastercardId): Card
    {
        $this->mastercardId = $mastercardId;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferralLinkId(): string
    {
        return $this->referralLinkId;
    }

    /**
     * @param string $referralLinkId
     *
     * @return Card
     */
    public function setReferralLinkId(string $referralLinkId): Card
    {
        $this->referralLinkId = $referralLinkId;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFirstCheck(): \DateTime
    {
        return $this->dateFirstCheck;
    }

    /**
     * @param \DateTime $dateFirstCheck
     *
     * @return Card
     */
    public function setDateFirstCheck(\DateTime $dateFirstCheck): Card
    {
        $this->dateFirstCheck = $dateFirstCheck;

        return $this;
    }

    /**
     * @return bool
     */
    public function isExternalCard(): bool
    {
        return $this->isExternalCard;
    }

    /**
     * @param bool $isExternalCard
     *
     * @return Card
     */
    public function setIsExternalCard(bool $isExternalCard): Card
    {
        $this->isExternalCard = $isExternalCard;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAccumSaleAmount(): Money
    {
        return $this->accumSaleAmount;
    }

    /**
     * @param Money $accumSaleAmount
     *
     * @return Card
     */
    public function setAccumSaleAmount(Money $accumSaleAmount): Card
    {
        $this->accumSaleAmount = $accumSaleAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getActivationShopId(): string
    {
        return $this->activationShopId;
    }

    /**
     * @param string $activationShopId
     *
     * @return Card
     */
    public function setActivationShopId(string $activationShopId): Card
    {
        $this->activationShopId = $activationShopId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return Card
     */
    public function setPhone(string $phone): Card
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Card
     */
    public function setEmail(string $email): Card
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalCardId(): ?string
    {
        return $this->externalCardId;
    }

    /**
     * @param string $externalCardId
     *
     * @return Card
     */
    public function setExternalCardId(string $externalCardId): Card
    {
        $this->externalCardId = $externalCardId;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUri(): string
    {
        return $this->imageUri;
    }

    /**
     * @param string $imageUri
     *
     * @return Card
     */
    public function setImageUri(string $imageUri): Card
    {
        $this->imageUri = $imageUri;

        return $this;
    }
}
