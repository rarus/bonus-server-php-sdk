<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\PersonalInfo;

use Rarus\BonusServer\Users;
use Rarus\BonusServer\Util\DateTimeParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Users\DTO\PersonalInfo
 */
class Fabric
{
    /**
     * @param array         $arUserPersonalInfo
     * @param \DateTimeZone $dateTimeZone
     *
     * @return PersonalInfo
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initFromServerResponse(array $arUserPersonalInfo, \DateTimeZone $dateTimeZone): PersonalInfo
    {
        $personalInfo = new PersonalInfo();

        $personalInfo
            ->setName($arUserPersonalInfo['name'])
            ->setPhone($arUserPersonalInfo['phone'])
            ->setEmail($arUserPersonalInfo['email'])
            ->setGender(Users\DTO\Gender\Fabric::initFromServerResponse($arUserPersonalInfo['gender']))
            ->setReceiveNotifications($arUserPersonalInfo['recieve_notifications']);
        if ($arUserPersonalInfo['birthdate'] !== 0) {
            $personalInfo->setBirthday(DateTimeParser::parseTimestampFromServerResponse((string)$arUserPersonalInfo['birthdate'], $dateTimeZone));
        }
        if ($arUserPersonalInfo['image'] !== '') {
            $personalInfo->setImage($arUserPersonalInfo['image']);
        }

        return $personalInfo;
    }
}
