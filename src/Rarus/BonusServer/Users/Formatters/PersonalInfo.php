<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Formatters;

use Rarus\BonusServer\Users;

/**
 * Class PersonalInfo
 *
 * @package Rarus\BonusServer\Users\Formatters
 */
class PersonalInfo
{
    /**
     * @param Users\DTO\PersonalInfo\PersonalInfo $userPersonalInfo
     *
     * @return array
     */
    public static function toArray(Users\DTO\PersonalInfo\PersonalInfo $userPersonalInfo): array
    {
        return [
            'name' => $userPersonalInfo->getName(),
            'phone' => $userPersonalInfo->getPhone(),
            'email' => $userPersonalInfo->getEmail(),
            'gender' => $userPersonalInfo->getGender() !== null ? $userPersonalInfo->getGender()->getCode() : null,
            'birthday' => $userPersonalInfo->getBirthday() !== null ? $userPersonalInfo->getBirthday()->format(\DATE_ATOM) : null,
            'recieve_notifications' => $userPersonalInfo->isReceiveNotifications(),
            'image' => $userPersonalInfo->getImage(),
        ];
    }
}