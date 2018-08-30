<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Level;

use \Money\Money;

/**
 * Уровни карты
 *
 * Class Level
 *
 * @package Rarus\BonusServer\Cards\DTO\Level
 */
final class Level
{
    /**
     * @var int Номер строки
     */
    private $rowNumber;
    /**
     * @var LevelId Идентификатор уровня
     */
    private $levelId;
    /**
     * @var string Наименование уровня
     */
    private $name;
    /**
     * @var int Порядок следования. 0 - первый уровень, далее просматриваются большие - в зависимости от текущего уровня карты и суммы накоплений
     */
    private $order;
    /**
     * @var Money Сумма накоплений, при достижении которой уровень становится доступным для перехода
     */
    private $accumulationAmountToNextLevel;
    /**
     * @var bool Сбрасывать сумму накопления при переходе на новый уровень
     */
    private $isResetAccumulationSumWhenUpgradeLevel;
    /**
     * @var int Максимальный процент при оплате чека, влияет на функцию post balance
     */
    private $maxPaymentPercent;
    /**
     * @var RestrictionRule
     */
    private $restrictionRule;

    /**
     * @return RestrictionRule
     */
    public function getRestrictionRule(): RestrictionRule
    {
        return $this->restrictionRule;
    }

    /**
     * @param RestrictionRule $restrictionRule
     *
     * @return Level
     */
    public function setRestrictionRule(RestrictionRule $restrictionRule): Level
    {
        $this->restrictionRule = $restrictionRule;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxPaymentPercent(): int
    {
        return $this->maxPaymentPercent;
    }

    /**
     * @param int $maxPaymentPercent
     *
     * @return Level
     */
    public function setMaxPaymentPercent(int $maxPaymentPercent): Level
    {
        $this->maxPaymentPercent = $maxPaymentPercent;

        return $this;
    }

    /**
     * @return bool
     */
    public function isResetAccumulationSumWhenUpgradeLevel(): bool
    {
        return $this->isResetAccumulationSumWhenUpgradeLevel;
    }

    /**
     * @param bool $isResetAccumulationSumWhenUpgradeLevel
     *
     * @return Level
     */
    public function setResetAccumulationSumWhenUpgradeLevel(bool $isResetAccumulationSumWhenUpgradeLevel): Level
    {
        $this->isResetAccumulationSumWhenUpgradeLevel = $isResetAccumulationSumWhenUpgradeLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }

    /**
     * @param int $rowNumber
     *
     * @return Level
     */
    public function setRowNumber(int $rowNumber): Level
    {
        $this->rowNumber = $rowNumber;

        return $this;
    }

    /**
     * @return LevelId
     */
    public function getLevelId(): LevelId
    {
        return $this->levelId;
    }

    /**
     * @param LevelId $levelId
     *
     * @return Level
     */
    public function setLevelId(LevelId $levelId): Level
    {
        $this->levelId = $levelId;

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
     * @return Level
     */
    public function setName(string $name): Level
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     *
     * @return Level
     */
    public function setOrder(int $order): Level
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAccumulationAmountToNextLevel(): Money
    {
        return $this->accumulationAmountToNextLevel;
    }

    /**
     * @param Money $accumulationAmountToNextLevel
     *
     * @return Level
     */
    public function setAccumulationAmountToNextLevel(Money $accumulationAmountToNextLevel): Level
    {
        $this->accumulationAmountToNextLevel = $accumulationAmountToNextLevel;

        return $this;
    }
}