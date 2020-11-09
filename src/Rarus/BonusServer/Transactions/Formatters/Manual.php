<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Transactions\Formatters;

/**
 * Class Manual
 *
 * @package Rarus\BonusServer\Transactions\Formatters
 */
class Manual
{
    public static function toArray(\Rarus\BonusServer\Transactions\DTO\Manual $manual): array
    {
        return [
            'card_id'                => $manual->getCardId()->getId(),
            'time'                   => $manual->getTime()->getTimestamp(),
            'type'                   => $manual->getType()->getCode() === 'sale' ? 1 : 0,
            'sum'                    => $manual->getSum(),
            'author'                 => $manual->getAuthorName(),
            'description'            => $manual->getDescription() ?? '',
            'doc_id'                 => $manual->getDocument()->getId(),
            'doc_type'               => $manual->getDocument()->getExternalId(),
            'kkm_id'                 => $manual->getCashRegister() ? $manual->getCashRegister()->getId() : null,
            'shop_id'                => $manual->getShopId()->getId(),
            'discount_id'            => $manual->getDiscountId() ? $manual->getDiscountId()->getId() : null,
            'check_activity_counter' => $manual->getCheckActivityCounter(),
            'invalidate_period'      => $manual->getInvalidatePeriod(),
            'activation_period'      => $manual->getActivationPeriod(),
            'activation_base_date'   => $manual->getActivationBaseDate(),
            'invalidate_base_date'   => $manual->getInvalidateBaseDate()
        ];
    }
}
