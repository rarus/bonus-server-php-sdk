<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Level;

use \Money\Money;

/**
 * Class LevelDescription
 *
 * @package Rarus\BonusServer\Cards\DTO\Level
 */
final class LevelDescription
{
    /**
     * @var LevelId
     */
    private $levelId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Money
     */
    private $cardAccumulationSum;
    /**
     * @var Money
     */
    private $levelUpAccumulationSum;

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
     * @return LevelDescription
     */
    public function setLevelId(LevelId $levelId): LevelDescription
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
     * @return LevelDescription
     */
    public function setName(string $name): LevelDescription
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Money
     */
    public function getCardAccumulationSum(): Money
    {
        return $this->cardAccumulationSum;
    }

    /**
     * @param Money $cardAccumulationSum
     *
     * @return LevelDescription
     */
    public function setCardAccumulationSum(Money $cardAccumulationSum): LevelDescription
    {
        $this->cardAccumulationSum = $cardAccumulationSum;

        return $this;
    }

    /**
     * @return Money
     */
    public function getLevelUpAccumulationSum(): Money
    {
        return $this->levelUpAccumulationSum;
    }

    /**
     * @param Money $levelUpAccumulationSum
     *
     * @return LevelDescription
     */
    public function setLevelUpAccumulationSum(Money $levelUpAccumulationSum): LevelDescription
    {
        $this->levelUpAccumulationSum = $levelUpAccumulationSum;

        return $this;
    }
}