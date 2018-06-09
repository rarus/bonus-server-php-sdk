<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Formatters;

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
            'status' => [
                'isConfirmed' => $user->getStatus()->isConfirmed(),
                'isBlocked' => $user->getStatus()->isBlocked(),
                'blockedDescription' => $user->getStatus()->getBlockedDescription(),
            ],
        ];
    }

    /**
     * @param BonusServer\Users\DTO\User $newUser
     *
     * @return array
     */
    public static function toArrayForCreateNewUser(BonusServer\Users\DTO\User $newUser): array
    {
        return [
            'login' => $newUser->getLogin(),
            'name' => $newUser->getName(),
            'phone' => $newUser->getPhone(),
            'email' => $newUser->getEmail(),
            'gender' => $newUser->getGender() === null ? '' : $newUser->getGender()->getCode(),
            'birthdate' => $newUser->getBirthdate() === null ? 0 : $newUser->getBirthdate()->getTimestamp(),
        ];
    }

    /**
     * @param BonusServer\Users\DTO\User $user
     *
     * @return array
     */
    public static function toArrayForImportNewUser(BonusServer\Users\DTO\User $user): array
    {
        return [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
            'gender' => $user->getGender() === null ? '' : $user->getGender()->getCode(),
            'birthdate' => $user->getBirthdate() === null ? 0 : $user->getBirthdate()->getTimestamp(),
            'isConfirmed' => $user->getStatus()->isConfirmed(),
            'isBlocked' => $user->getStatus()->isBlocked(),
            'blockedDescription' => $user->getStatus()->getBlockedDescription(),
            'password' => $user->getPasswordHash() ?? '',
        ];
    }
}