<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points;

use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\Type;

use Rarus\BonusServer\Util\DateTimeParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Points
 */
class Fabric
{
    /**
     * @param Currency      $currency
     * @param array         $arPoint
     * @param \DateTimeZone $dateTimeZone
     *
     * @return Point
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initPointFromServerResponse(Currency $currency, array $arPoint, \DateTimeZone $dateTimeZone): Point
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        $point = new Point();
        $point
            ->setSum($moneyParser->parse((string)$arPoint['sum'], $currency->getCode()))
            ->setDateCreate(DateTimeParser::parseTimestampFromServerResponse((string)$arPoint['date'], $dateTimeZone));

        if ($arPoint['active_from'] !== 0) {
            $point->setActiveFrom(DateTimeParser::parseTimestampFromServerResponse((string)$arPoint['active_from'], $dateTimeZone));
        }
        if ($arPoint['active_to'] !== 0) {
            $point->setActiveFrom(DateTimeParser::parseTimestampFromServerResponse((string)$arPoint['active_to'], $dateTimeZone));
        }

        return $point;
    }
}