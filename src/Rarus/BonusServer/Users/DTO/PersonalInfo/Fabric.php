<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\PersonalInfo;

use Rarus\BonusServer\Users;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Users\DTO\PersonalInfo
 */
class Fabric
{
    /**
     * @param array $arUserPersonalInfo
     *
     * @return PersonalInfo
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initFromServerResponse(array $arUserPersonalInfo): PersonalInfo
    {
        $personalInfo = new PersonalInfo();

        $personalInfo
            ->setName($arUserPersonalInfo['name'])
            ->setPhone($arUserPersonalInfo['phone'])
            ->setEmail($arUserPersonalInfo['email'])
            ->setGender(Users\DTO\Gender\Fabric::initFromServerResponse($arUserPersonalInfo['gender']))
            ->setReceiveNotifications($arUserPersonalInfo['recieve_notifications']);
        if ($arUserPersonalInfo['birthdate'] !== 0) {
            $personalInfo->setBirthday(\DateTime::createFromFormat('U', (string)$arUserPersonalInfo['birthdate']));
        }
        if ($arUserPersonalInfo['image'] !== '') {
            $personalInfo->setImage($arUserPersonalInfo['image']);
        }

        return $personalInfo;
    }
}