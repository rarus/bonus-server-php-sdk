<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Level;

/**
 * Class RestrictionRule
 *
 * @package Rarus\BonusServer\Cards\DTO\Level
 */
final class RestrictionRule
{
    // Период количества операций - за какой период количество операций не должно превышать указанное в параметре $allowedOperationNumber
    // 0 - Нет контроля
    // 1 - День
    // 2 - Неделя
    // 3 - Месяц
    // 4 - Квартал
    // 5 - Год
    /**
     * @var int
     */
    private $minimumOperationCountPeriodId;
    /**
     * @var int Допустимое количество операций
     */
    private $allowedOperationNumber;
    /**
     * @var int Дней не активности по карте до сгорания всех бонусов
     */
    private $inactivityDaysBeforeBonusesWillBeErased;

    /**
     * RestrictionRule constructor.
     *
     * @param int $minimumOperationCountPeriodId
     * @param int $allowedOperationNumber
     * @param int $inactivityDaysBeforeBonusesWillBeErased
     */
    public function __construct(int $minimumOperationCountPeriodId = 0, int $allowedOperationNumber = 0, int $inactivityDaysBeforeBonusesWillBeErased = 0)
    {
        $this->minimumOperationCountPeriodId = $minimumOperationCountPeriodId;
        $this->allowedOperationNumber = $allowedOperationNumber;
        $this->inactivityDaysBeforeBonusesWillBeErased = $inactivityDaysBeforeBonusesWillBeErased;
    }

    /**
     * @return int
     */
    public function getMinimumOperationCountPeriodId(): int
    {
        return $this->minimumOperationCountPeriodId;
    }

    /**
     * @return int
     */
    public function getAllowedOperationNumber(): int
    {
        return $this->allowedOperationNumber;
    }

    /**
     * @return int
     */
    public function getInactivityDaysBeforeBonusesWillBeErased(): int
    {
        return $this->inactivityDaysBeforeBonusesWillBeErased;
    }
}
