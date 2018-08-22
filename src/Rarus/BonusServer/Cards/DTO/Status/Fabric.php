<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Status;

use Money\Money;
use Rarus\BonusServer\Util\DateTimeParser;

class Fabric
{
    /**
     * @param array         $arCard
     * @param \DateTimeZone $dateTimeZone
     *
     * @return CardStatus
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initFromServerResponse(array $arCard, \DateTimeZone $dateTimeZone): CardStatus
    {
        $cardStatus = (new CardStatus())
            ->setIsActive((bool)$arCard['active'])
            ->setIsBlocked((bool)$arCard['blocked'])
            ->setBlockedDescription((string)$arCard['blockeddescription']);

        if ($arCard['date_active'] !== 0) {
            $cardStatus->setDateActivate(DateTimeParser::parseTimestampFromServerResponse((string)$arCard['date_active'], $dateTimeZone));
        }
        if ($arCard['date_deactivate'] !== 0) {
            $cardStatus->setDateDeactivate(DateTimeParser::parseTimestampFromServerResponse((string)$arCard['date_deactivate'], $dateTimeZone));
        }

        return $cardStatus;
    }

    /**
     * @return CardStatus
     */
    public static function initDefaultStatusForNewCard(): CardStatus
    {
        $cardStatus = (new CardStatus())
            ->setIsActive(false)
            ->setIsBlocked(false);

        return $cardStatus;
    }
}
