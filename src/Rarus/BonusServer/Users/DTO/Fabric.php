<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO;

use \Rarus\BonusServer\Users;
use Rarus\BonusServer\Util\DateTimeParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Users\DTO
 */
class Fabric
{

    /**
     * @param array         $arUser
     * @param \DateTimeZone $dateTimeZone
     *
     * @return User
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initUserFromServerResponse(array $arUser, \DateTimeZone $dateTimeZone): User
    {
        $user = (new User())
            ->setUserId(new UserId($arUser['id']))
            ->setLogin($arUser['login'])
            ->setName($arUser['name'])
            ->setPhone($arUser['phone'])
            ->setStatus(Users\DTO\Status\Fabric::initFromServerResponse($arUser))
            ->setImageUrl($arUser['image'])
            ->setEmail($arUser['email']);
        if ($arUser['gender'] !== 'none') {
            $user->setGender(Users\DTO\Gender\Fabric::initFromServerResponse($arUser['gender']));
        }
        if ($arUser['birthdate'] !== 0) {
            $birthday = DateTimeParser::parseTimestampFromServerResponse((string)$arUser['birthdate'], $dateTimeZone);
            $user->setBirthdate($birthday);
        }

        return $user;
    }

    /**
     * создание объекта нового пользователя
     *
     * @param string                 $login
     * @param string                 $name
     * @param string                 $phone
     * @param string                 $email
     * @param Gender\Gender|null     $gender
     * @param \DateTime|null         $birthday
     * @param string|null            $passwordHash
     * @param UserId|null            $userId
     * @param Status\UserStatus|null $status
     *
     * @return User
     */
    public static function createNewInstance(string $login, string $name, string $phone, string $email, Users\DTO\Gender\Gender $gender = null, \DateTime $birthday = null, string $passwordHash = null, ?UserId $userId = null, ?Status\UserStatus $status = null): User
    {
        $user = (new User())
            ->setLogin($login)
            ->setName($name)
            ->setPhone($phone)
            ->setEmail($email);
        if ($gender !== null) {
            $user->setGender($gender);
        }
        if ($birthday !== null) {
            $user->setBirthdate($birthday);
        }
        if ($passwordHash !== null) {
            $user->setPasswordHash($passwordHash);
        }
        if ($userId !== null) {
            $user->setUserId($userId);
        }
        if ($status !== null) {
            $user->setStatus($status);
        }

        return $user;
    }
}