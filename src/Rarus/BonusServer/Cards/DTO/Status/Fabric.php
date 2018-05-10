<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Status;

use Money\Money;

class Fabric
{
    /**
     * @param array $arCard
     *
     * @return CardStatus
     */
    public static function initFromServerResponse(array $arCard): CardStatus
    {
        $cardStatus = (new CardStatus())
            ->setIsActive((bool)$arCard['active'])
            ->setIsBlocked((bool)$arCard['blocked'])
            ->setBlockedDescription((string)$arCard['blockeddescription']);

        if ($arCard['date_active'] !== 0) {
            $cardStatus->setDateActivate(\DateTime::createFromFormat('U', (string)$arCard['date_active']));
        }
        if ($arCard['date_deactivate'] !== 0) {
            $cardStatus->setDateDeactivate(\DateTime::createFromFormat('U', (string)$arCard['date_deactivate']));
        }

        return $cardStatus;
    }
}
