<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Shops\DTO;

/**
 * Class Schedule
 *
 * @package Rarus\BonusServer\Shops\Schedule\DTO
 */
final class Schedule
{
    /**
     *
     * @var int День недели начала периода
     */
    private $dayStart;

    /**
     * @var int День недели конца периода
     */
    private $dayEnd;

    /**
     * @var int
     */
    private $timeStart;

    /**
     * @var int
     */
    private $timeEnd;

    /**
     * @var bool
     */
    private $isOpen;

    /**
     * @return int
     */
    public function getDayStart(): int
    {
        return $this->dayStart;
    }

    /**
     * @param int $dayStart
     *
     * @return Schedule
     */
    public function setDayStart(int $dayStart): Schedule
    {
        $this->dayStart = $dayStart;

        return $this;
    }

    /**
     * @return int
     */
    public function getDayEnd(): int
    {
        return $this->dayEnd;
    }

    /**
     * @param int $dayEnd
     *
     * @return Schedule
     */
    public function setDayEnd(int $dayEnd): Schedule
    {
        $this->dayEnd = $dayEnd;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeStart(): int
    {
        return $this->timeStart;
    }

    /**
     * @param int $timeStart
     *
     * @return Schedule
     */
    public function setTimeStart(int $timeStart): Schedule
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeEnd(): int
    {
        return $this->timeEnd;
    }

    /**
     * @param int $timeEnd
     *
     * @return Schedule
     */
    public function setTimeEnd(int $timeEnd): Schedule
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    /**
     * @param bool $isOpen
     *
     * @return Schedule
     */
    public function setIsOpen(bool $isOpen): Schedule
    {
        $this->isOpen = $isOpen;

        return $this;
    }
}