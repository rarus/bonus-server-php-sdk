<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\CashRegister;

/**
 * Class CashRegister
 *
 * @package Rarus\BonusServer\Transactions\DTO\CashRegister
 */
final class CashRegister
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return CashRegister
     */
    public function setId(string $id): CashRegister
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
     * @return CashRegister
     */
    public function setName(string $name): CashRegister
    {
        $this->name = $name;

        return $this;
    }
}