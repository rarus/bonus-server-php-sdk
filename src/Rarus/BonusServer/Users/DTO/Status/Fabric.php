<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\Status;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Users\DTO\Status
 */
class Fabric
{
    /**
     * @param array $arUser
     *
     * @return UserStatus
     */
    public static function initFromServerResponse(array $arUser): UserStatus
    {
        $userStatus = (new UserStatus())
            ->setIsConfirmed((bool)$arUser['confirmed'])
            ->setIsBlocked((bool)$arUser['is_locked'])
            ->setBlockedDescription((string)$arUser['blockeddescription']);

        return $userStatus;
    }

    /**
     * @return UserStatus
     */
    public static function initDefaultStatusForNewUser(): UserStatus
    {
        $userStatus = (new UserStatus())
            ->setIsConfirmed(false)
            ->setIsBlocked(false);

        return $userStatus;
    }
}