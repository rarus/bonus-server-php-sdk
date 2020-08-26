<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\CashRegister;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\CashRegister
 */
class Fabric
{
    /**
     * @param string $id
     * @param string $name
     *
     * @return CashRegister
     */
    public static function createNewInstance(string $id, string $name): CashRegister
    {
        $kkm = new CashRegister();
        $kkm
            ->setId($id)
            ->setName($name);

        return $kkm;
    }
}
