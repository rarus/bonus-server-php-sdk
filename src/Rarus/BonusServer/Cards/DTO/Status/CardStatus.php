<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Status;

/**
 * DTO объект статус карты
 *
 * Class CardStatus
 *
 * @package Rarus\BonusServer\Cards\DTO
 */
class CardStatus
{
    /**
     * @var bool Признак блокировки карты
     */
    protected $isBlocked;
    /**
     * @var string|null Описание причины блокировки.
     */
    protected $blockedDescription;
    /**
     * @var bool Признак активности карты
     */
    protected $isActive;
    /**
     * @var \DateTime|null Дата активации карты
     */
    protected $dateActivate;
    /**
     * @var \DateTime|null Дата деактивации карты
     */
    protected $dateDeactivate;

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    /**
     * @param bool $isBlocked
     *
     * @return CardStatus
     */
    public function setIsBlocked(bool $isBlocked): CardStatus
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBlockedDescription(): ?string
    {
        return $this->blockedDescription;
    }

    /**
     * @param null|string $blockedDescription
     *
     * @return CardStatus
     */
    public function setBlockedDescription(?string $blockedDescription): CardStatus
    {
        $this->blockedDescription = $blockedDescription;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return CardStatus
     */
    public function setIsActive(bool $isActive): CardStatus
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateActivate(): ?\DateTime
    {
        return $this->dateActivate;
    }

    /**
     * @param \DateTime|null $dateActivate
     *
     * @return CardStatus
     */
    public function setDateActivate(?\DateTime $dateActivate): CardStatus
    {
        $this->dateActivate = $dateActivate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateDeactivate(): ?\DateTime
    {
        return $this->dateDeactivate;
    }

    /**
     * @param \DateTime|null $dateDeactivate
     *
     * @return CardStatus
     */
    public function setDateDeactivate(?\DateTime $dateDeactivate): CardStatus
    {
        $this->dateDeactivate = $dateDeactivate;

        return $this;
    }
}
