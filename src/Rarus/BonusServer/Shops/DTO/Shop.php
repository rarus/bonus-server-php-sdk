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
     * @var string
     */
    private $id;

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
     * Временная зона
     *
     * @var \DateTimeZone
     */
    private $timeZone;

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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Shop
     */
    public function setId(string $id): Shop
    {
        $this->id = $id;

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
     * @return float
     */
    public function getLatitude(): float
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
     * @return float
     */
    public function getLongitude(): float
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
     * @return string
     */
    public function getAddress(): string
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
     * @return string
     */
    public function getPhone(): string
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
     * @return \DateTimeZone
     */
    public function getTimeZone(): \DateTimeZone
    {
        return $this->timeZone;
    }

    /**
     * @param \DateTimeZone $timeZone
     *
     * @return Shop
     */
    public function setTimeZone(\DateTimeZone $timeZone): Shop
    {
        $this->timeZone = $timeZone;

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
     * @return string
     */
    public function getExcludeArticles(): string
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