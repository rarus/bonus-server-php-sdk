<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO;

use Rarus\BonusServer\Cards\DTO\Barcode\Barcode;
use Rarus\BonusServer\Users\DTO\UserId;

/**
 * Class CardFilter для фильтрации карт
 *
 * @package Rarus\BonusServer\Cards\DTO
 */
class CardFilter
{
    /**
     * @var UserId
     */
    protected $userId;
    /**
     * @var Barcode|null
     *
     */
    protected $barcode;
    /**
     * @var string
     */
    protected $code;
    /**
     * @var string|null
     */
    protected $cardLevelId;
    /**
     * @var string|null
     */
    protected $email;
    /**
     * @var string|null
     */
    protected $phone;
    /**
     * @var null|bool
     */
    protected $active;
    /**
     * @var null|bool
     */
    protected $blocked;

    /**
     * @return string|null
     */
    public function getSearchValue(): ?string
    {
        return $this->searchValue;
    }

    /**
     * @param string|null $searchValue
     */
    public function setSearchValue(?string $searchValue): void
    {
        $this->searchValue = $searchValue;
    }
    /**
     * @var null|string
     */
    protected $searchValue;

    /**
     * @return null|Barcode
     */
    public function getBarcode(): ?Barcode
    {
        return $this->barcode;
    }

    /**
     * @param null|Barcode $barcode
     *
     * @return CardFilter
     */
    public function setBarcode(?Barcode $barcode): CardFilter
    {
        $this->barcode = $barcode;

        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return CardFilter
     */
    public function setCode(string $code): CardFilter
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCardLevelId(): ?string
    {
        return $this->cardLevelId;
    }

    /**
     * @param null|string $cardLevelId
     *
     * @return CardFilter
     */
    public function setCardLevelId(?string $cardLevelId): CardFilter
    {
        $this->cardLevelId = $cardLevelId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     *
     * @return CardFilter
     */
    public function setEmail(?string $email): CardFilter
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     *
     * @return CardFilter
     */
    public function setPhone(?string $phone): CardFilter
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return UserId
     */
    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    /**
     * @param UserId $userId
     */
    public function setUserId(UserId $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     */
    public function setActive(): void
    {
        $this->active = true;
    }

    /**
     * @return bool|null
     */
    public function getBlocked(): ?bool
    {
        return $this->blocked;
    }

    /**
     */
    public function setBlocked(): void
    {
        $this->blocked = true;
    }
}
