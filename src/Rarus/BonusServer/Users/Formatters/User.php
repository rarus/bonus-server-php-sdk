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
            'status' => [
                'isConfirmed' => $user->getStatus()->isConfirmed(),
                'isBlocked' => $user->getStatus()->isBlocked(),
                'blockedDescription' => $user->getStatus()->getBlockedDescription(),
            ],
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
            'isConfirmed' => $newUser->getStatus()->isConfirmed(),
            'isBlocked' => $newUser->getStatus()->isBlocked(),
            'blockedDescription' => $newUser->getStatus()->getBlockedDescription(),
            'password' => $newUser->getPasswordHash() ?? '',
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