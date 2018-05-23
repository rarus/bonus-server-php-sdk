<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Level;

use \Money\Money;

/**
 * Class Level
 *
 * @package Rarus\BonusServer\Cards\DTO\Level
 */
final class Level
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Money Оборот накоплений по карте
     */
    private $accumAmount;
    /**
     * @var Money сумма порога для перехода на следующий уровень
     */
    private $accumLevel;

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
     * @return Level
     */
    public function setId(string $id): Level
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
     * @return Level
     */
    public function setName(string $name): Level
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAccumAmount(): Money
    {
        return $this->accumAmount;
    }

    /**
     * @param Money $accumAmount
     *
     * @return Level
     */
    public function setAccumAmount(Money $accumAmount): Level
    {
        $this->accumAmount = $accumAmount;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAccumLevel(): Money
    {
        return $this->accumLevel;
    }

    /**
     * @param Money $accumLevel
     *
     * @return Level
     */
    public function setAccumLevel(Money $accumLevel): Level
    {
        $this->accumLevel = $accumLevel;

        return $this;
    }
}