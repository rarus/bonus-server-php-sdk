<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\Formatters;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Rarus\BonusServer;

/**
 * Class AuthToken
 *
 * @package Rarus\BonusServer\Users\Formatters
 */
class User
{
    /**
     * @param BonusServer\Users\DTO\User $user
     *
     * @return array
     */
    public static function toArray(BonusServer\Users\DTO\User $user): array
    {
        return [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'birthday' => $user->getBirthdate() === null ? null : $user->getBirthdate()->format(\DateTime::ATOM),
            'gender' => $user->getGender() === null ? null : $user->getGender()->getCode(),
            'imageUrl' => $user->getImageUrl(),
            'recieve_notifications' => $user->isReceiveNotifications(),
            'status' => [
                'confirmed' => (int)$user->getStatus()->isConfirmed(),
                'is_locked' => (int)$user->getStatus()->isBlocked(),
            ],
        ];
    }

    /**
     * @param BonusServer\Users\DTO\User $user
     *
     * @return array
     */
    public static function toArrayForUpdateUser(BonusServer\Users\DTO\User $user): array
    {
        $arUpdatedUser = [
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'gender' => $user->getGender() === null ? null : $user->getGender()->getCode(),
            'recieve_notifications' => (int)$user->isReceiveNotifications(),
            'confirmed' => (int)$user->getStatus()->isConfirmed(),
            'is_locked' => (int)$user->getStatus()->isBlocked(),
        ];

        if ($user->getBirthdate() !== null) {
            $utcBirthday = new \DateTime($user->getBirthdate()->format('d.m.Y H:i:s'), new \DateTimeZone('UTC'));
            $arUpdatedUser['birthdate'] = BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp($utcBirthday);
        } else {
            $arUpdatedUser['birthdate'] = 0;
        }

        return $arUpdatedUser;
    }

    /**
     * @param BonusServer\Users\DTO\User $newUser
     *
     * @return array
     */
    public static function toArrayForViewNewUserData(BonusServer\Users\DTO\User $newUser): array
    {
        return [
            'login' => $newUser->getLogin(),
            'name' => $newUser->getName(),
            'email' => $newUser->getEmail(),
            'phone' => $newUser->getPhone(),
            'birthday' => $newUser->getBirthdate() === null ? null : $newUser->getBirthdate()->format(\DateTime::ATOM),
            'gender' => $newUser->getGender() === null ? null : $newUser->getGender()->getCode(),
            'imageUrl' => $newUser->getImageUrl(),
            'recieve_notifications' => (int)$newUser->isReceiveNotifications(),
        ];
    }

    /**
     * @param BonusServer\Users\DTO\User $newUser
     * @param \DateTimeZone              $dateTimeZone
     *
     * @return array
     */
    public static function toArrayForCreateNewUser(BonusServer\Users\DTO\User $newUser, \DateTimeZone $dateTimeZone): array
    {
        $arNewUser = [
            'login' => $newUser->getLogin(),
            'name' => $newUser->getName(),
            'phone' => $newUser->getPhone(),
            'email' => $newUser->getEmail(),
            'gender' => $newUser->getGender() === null ? '' : $newUser->getGender()->getCode(),
            'recieve_notifications' => (int)$newUser->isReceiveNotifications(),
        ];
        if ($newUser->getBirthdate() !== null) {
            $utcBirthday = new \DateTime($newUser->getBirthdate()->format('d.m.Y H:i:s'), new \DateTimeZone('UTC'));
            $arNewUser['birthdate'] = BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp($utcBirthday);
        } else {
            $arNewUser['birthdate'] = 0;
        }

        return $arNewUser;
    }

    /**
     * @param BonusServer\Users\DTO\User $newUser
     * @param \DateTimeZone              $dateTimeZone
     *
     * @return array
     */
    public static function toArrayForImportNewUser(BonusServer\Users\DTO\User $newUser, \DateTimeZone $dateTimeZone): array
    {
        $arNewUser = [
            'id' => $newUser->getUserId()->getId(),
            'login' => $newUser->getLogin(),
            'name' => $newUser->getName(),
            'phone' => $newUser->getPhone(),
            'email' => $newUser->getEmail(),
            'gender' => $newUser->getGender() === null ? '' : $newUser->getGender()->getCode(),
            'confirmed' => (int)$newUser->getStatus()->isConfirmed(),
            'is_locked' => (int)$newUser->getStatus()->isBlocked(),
            'password' => $newUser->getPasswordHash() ?? '',
            'recieve_notifications' => (int)$newUser->isReceiveNotifications(),
        ];
        if ($newUser->getBirthdate() !== null) {
            $gmtOffsetInSeconds = $dateTimeZone->getOffset(new \DateTime('now', $dateTimeZone));
            $gmtTimestamp = (string)($newUser->getBirthdate()->getTimestamp() - $gmtOffsetInSeconds);
            $arNewUser['birthdate'] = BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp(\DateTime::createFromFormat('U', $gmtTimestamp, $dateTimeZone));
        } else {
            $arNewUser['birthdate'] = 0;
        }

        return $arNewUser;
    }
}
