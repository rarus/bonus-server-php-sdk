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
            'barcode' => $card->getBarcode()->getCode(),
            'description' => $card->getDescription(),
            'last_transaction' => $card->getLastTransaction(),
            'accum_sale_amount' => $card->getAccumSaleAmount()->getAmount(),
            'date_last_transaction' => $card->getDateLastTransaction() !== null ?
                $card->getDateLastTransaction()->format(\DATE_ATOM) : null,
            'userId' => $card->getUserId() !== null ?
                $card->getUserId()->getId() : null,
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

    /**
     * @param BonusServer\Cards\DTO\Card $newCard
     *
     * @return array
     */
    public static function toArrayForCreateNewCard(BonusServer\Cards\DTO\Card $newCard): array
    {
        $arNewCard = [
            'code' => $newCard->getCode(),
            'barcode' => $newCard->getBarcode()->getCode(),
            'accum_sale_amount' => (int)$newCard->getAccumSaleAmount()->getAmount(),
        ];

        if ($newCard->getCardLevelId() instanceof BonusServer\Cards\DTO\Level\LevelId) {
            $arNewCard['card_level_id'] = $newCard->getCardLevelId()->getId();
        }

        return $arNewCard;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return array
     */
    public static function toArrayForUpdateCard(BonusServer\Cards\DTO\Card $card): array
    {
        return [
            'parent_id' => $card->getParentId() === null ? '' : $card->getParentId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode()->getCode(),
            'name' => $card->getName() ?? '',
            'description' => $card->getDescription() ?? '',
            'mastercard_id' => $card->getMastercardId() ?? '',
            'phone' => $card->getPhone() ?? '',
            'email' => $card->getEmail() ?? '',
            'external_card' => $card->getExternalCardId() ?? 0,
            'accum_sale_amount' => (int)$card->getAccumSaleAmount()->getAmount(),
        ];
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return array
     */
    public static function toArrayForImportUsersAndCards(BonusServer\Cards\DTO\Card $card): array
    {
        return [
            'row_number'            => 0,
            'id'                    => $card->getCardId()->getId(),
            'parent_id'             => $card->getParentId() !== null ? $card->getParentId()->getId() : null,
            'name'                  => $card->getName() ?? '',
            'code'                  => $card->getCode(),
            'barcode'               => $card->getBarcode()->getCode(),
            'description'           => $card->getDescription() ?? '',
            'active'                => $card->getCardStatus()->isActive(),
            'blocked'               => $card->getCardStatus()->isBlocked(),
            'blockeddescription'    => $card->getCardStatus()->getBlockedDescription(),
            'balance'               => $card->getBalance(),
            'mastercard_id'         => $card->getMastercardId(),
            'referallink_id'        => $card->getReferralLinkId(),
            'firstchequedate'       => $card->getDateFirstCheck() ? $card->getDateFirstCheck()->getTimestamp() : null,
            'date_last_transaction' => $card->getDateLastTransaction() !== null ?
                $card->getDateLastTransaction()->getTimestamp() : null,
        ];
    }
}
