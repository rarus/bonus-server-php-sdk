<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Formatters;

use Rarus\BonusServer;

/**
 * Class AuthToken
 *
 * @package Rarus\BonusServer\Card\Formatters
 */
class Card
{
    /**
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return array
     */
    public static function toArray(BonusServer\Cards\DTO\Card $card): array
    {
        return [
            'id' => $card->getCardId()->getId(),
            'parent_id' => $card->getParentId() !== null ? $card->getParentId()->getId() : null,
            'name' => $card->getName(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode(),
            'description' => $card->getDescription(),
            'last_transaction' => $card->getLastTransaction(),
            'date_last_transaction' => $card->getDateLastTransaction() !== null ?
                $card->getDateLastTransaction()->format(\DATE_ATOM) : null,
            'status' => [
                'is_active' => $card->getCardStatus()->isActive(),
                'is_blocked' => $card->getCardStatus()->isBlocked(),
                'blocked_description' => $card->getCardStatus()->getBlockedDescription(),
                'date_activate' => $card->getCardStatus()->getDateActivate() !== null ?
                    $card->getCardStatus()->getDateActivate()->format(\DATE_ATOM) : null,
                'date_deactivate' => $card->getCardStatus()->getDateDeactivate() !== null ?
                    $card->getCardStatus()->getDateDeactivate()->format(\DATE_ATOM) : null,
            ],
        ];
    }
}
