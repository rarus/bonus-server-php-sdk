<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Shops\DTO;

/**
 * DTO Объект, описывающий сущность "Магазин"
 *
 * Class Shop
 *
 * @package Rarus\BonusServer\Shops\DTO
 */
final class Shop
{
    /**
     * Идентификатор магазина
     *
     * @var ShopId
     */
    private $shopId;

    /**
     * Наименование магазина
     *
     * @var string
     */
    private $name;

    /**
     * Широта
     *
     * @var float
     */
    private $latitude;

    /**
     * Долгота
     *
     * @var float
     */
    private $longitude;

    /**
     * Адрес магазина
     *
     * @var string
     */
    private $address;

    /**
     * Телефон
     *
     * @var string
     */
    private $phone;

    /**
     * @var bool
     */
    private $isDeleted;

    /**
     * Идентификатор сегмента номенклатуры, которую запрещено оплачивать бонусами.
     *
     * @var string
     */
    private $excludeArticles;
    /**
     * @var ScheduleCollection
     */
    private $schedule;
    /**
     * @var int
     */
    private $timezoneOffset;

    /**
     * @return int
     */
    public function getTimezoneOffset(): ?int
    {
        return $this->timezoneOffset;
    }

    /**
     * @param int $timezoneOffset
     *
     * @return Shop
     */
    public function setTimezoneOffset(int $timezoneOffset): Shop
    {
        $this->timezoneOffset = $timezoneOffset;

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
     * @return Shop
     */
    public function setShopId(ShopId $shopId): Shop
    {
        $this->shopId = $shopId;

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
     * @return Shop
     */
    public function setName(string $name): Shop
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return Shop
     */
    public function setLatitude(float $latitude): Shop
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     *
     * @return Shop
     */
    public function setLongitude(float $longitude): Shop
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Shop
     */
    public function setAddress(string $address): Shop
    {
        $this->address = $address;

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
     * @return Shop
     */
    public function setPhone(string $phone): Shop
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     *
     * @return Shop
     */
    public function setIsDeleted(bool $isDeleted): Shop
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExcludeArticles(): ?string
    {
        return $this->excludeArticles;
    }

    /**
     * @param string $excludeArticles
     *
     * @return Shop
     */
    public function setExcludeArticles(string $excludeArticles): Shop
    {
        $this->excludeArticles = $excludeArticles;

        return $this;
    }

    /**
     * @return ScheduleCollection
     */
    public function getSchedule(): ScheduleCollection
    {
        return $this->schedule;
    }

    /**
     * @param ScheduleCollection $schedule
     *
     * @return Shop
     */
    public function setSchedule(ScheduleCollection $schedule): Shop
    {
        $this->schedule = $schedule;

        return $this;
    }
}
