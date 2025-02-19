<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO\DiscountItems;

use Money\Currency;
use Money\Money;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Segments\DTO\SegmentId;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Discounts\DTO\DocumentItems
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $discountItem
     *
     * @return DiscountItem
     */
    public static function initFromServerResponse(Currency $currency, array $discountItem): DiscountItem
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        $item = new DiscountItem();
        $item
            ->setLineNumber((int)$discountItem['line_number'])
            ->setDiscountId(new DiscountId((string)$discountItem['discount_id']))
            ->setTypeId((int)$discountItem['discount_type'])
            ->setSum($moneyParser->parse((string)$discountItem['discount_summ'], $currency))
            ->setName((string)$discountItem['discount_name'])
            ->setValue((int)$discountItem['discount_value']);

        if ($discountItem['gift_list_id'] !== '') {
            $item->setGiftSegment(new SegmentId((string)$discountItem['gift_list_id']));
        }

        return $item;
    }
}
