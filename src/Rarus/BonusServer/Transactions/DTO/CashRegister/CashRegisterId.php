<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\CashRegister;

/**
 * Class CashRegisterId
 *
 * @package Rarus\BonusServer\Transactions\DTO\CashRegister
 */
class CashRegisterId
{
    /**
     * @var string
     */
    private $id;

    /**
     * CashRegisterId constructor.
     *
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
