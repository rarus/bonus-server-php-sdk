<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Formatters;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Rarus\BonusServer\Discounts\DTO\DiscountItems\DiscountItem;
use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Util\MoneyParser;

/**
 * Class DiscountRow
 *
 * @package Rarus\BonusServer\Discounts\Formatters
 */
class DiscountRow
{
    public static function toArray(DiscountItem $discountItem): array
    {
        $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        return [
            'line_number'    => $discountItem->getLineNumber(),
            'discount_id'    => $discountItem->getDiscountId()->getId(),
            'discount_type'  => $discountItem->getTypeId(),
            'discount_summ'  => (float)$decimalFormatter->format($discountItem->getSum()),
            'gift_list_id'   => $discountItem->getGiftSegment() ?: '',
            'discount_name'  => $discountItem->getName(),
            'discount_value' => $discountItem->getValue(),
        ];
    }

    public static function toCalculateHistory(DiscountItem $discountItem): array
    {
        return [
            'line_number' => $discountItem->getLineNumber(),
            'discount_id' => $discountItem->getDiscountId()->getId() ?: '',
            'discount_summ' => (float)MoneyParser::convertMoneyToString($discountItem->getSum())
        ];
    }
}
