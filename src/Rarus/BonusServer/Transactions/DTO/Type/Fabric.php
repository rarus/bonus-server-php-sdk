<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Type;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Type
 */
class Fabric
{
    /**
     * @return Type
     */
    public static function getSale(): Type
    {
        return new Type('sale');
    }

    /**
     * @return Type
     */
    public function getRefund(): Type
    {
        return new Type('refund');
    }
}