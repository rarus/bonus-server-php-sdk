<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO;

/**
 * Class CardFilter для фильтрации карт
 *
 * @package Rarus\BonusServer\Cards\DTO
 */
class CardFilter
{
    /**
     * @var string|null
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
     * @return null|string
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param null|string $barcode
     *
     * @return CardFilter
     */
    public function setBarcode(?string $barcode): CardFilter
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
}