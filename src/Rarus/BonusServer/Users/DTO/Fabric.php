<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO;

use \Rarus\BonusServer\Users;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Users\DTO
 */
class Fabric
{

    /**
     * @param array $arUser
     *
     * @return User
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initUserFromServerResponse(array $arUser): User
    {
        $user = (new User())
            ->setUserId(new UserId($arUser['id']))
            ->setName($arUser['name'])
            ->setPhone($arUser['phone'])
            ->setStatus(Users\DTO\Status\Fabric::initFromServerResponse($arUser))
            ->setImageUrl($arUser['image'])
            ->setEmail($arUser['email']);
        if ($arUser['gender'] !== '') {
            $user->setGender(Users\DTO\Gender\Fabric::initFromServerResponse($arUser['gender']));
        }
        if ($arUser[''] !== 0) {
            $user->setBirthdate(\DateTime::createFromFormat('U', (string)$arUser['birthdate']));
        }

        return $user;
    }

    /**
     * создание объекта нового пользователя
     *
     * @param string             $login
     * @param string             $name
     * @param string             $phone
     * @param string             $email
     * @param Gender\Gender|null $gender
     * @param \DateTime|null     $bithday
     *
     * @return User
     */
    public static function createNewInstance(string $login, string $name, string $phone, string $email, Users\DTO\Gender\Gender $gender = null, \DateTime $bithday = null): User
    {
        $user = (new User())
            ->setLogin($login)
            ->setName($name)
            ->setPhone($phone)
            ->setEmail($email);
        if ($gender !== null) {
            $user->setGender($gender);
        }
        if ($bithday !== null) {
            $user->setBirthdate($bithday);
        }

        return $user;
    }
}