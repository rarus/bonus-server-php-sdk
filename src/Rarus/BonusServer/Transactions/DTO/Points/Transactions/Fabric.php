<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points\Transactions;

use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\Type;
use Rarus\BonusServer\Transactions\DTO\Points\PointId;
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
     * @param array         $arPointTransaction
     * @param \DateTimeZone $dateTimeZone
     *
     * @return Transaction
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initPointTransactionFromServerResponse(Currency $currency, array $arPointTransaction, \DateTimeZone $dateTimeZone): Transaction
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        $pointTrx = new Transaction();
        $pointTrx
            ->setRowNumber((int)$arPointTransaction['row_number'])
            ->setPointId(new PointId((string)$arPointTransaction['id']))
            ->setCardId(new CardId((string)$arPointTransaction['card_id']))
            ->setMastercardId(new CardId((string)$arPointTransaction['mastercard_id']))
            ->setTime(DateTimeParser::parseTimestampFromServerResponse((string)$arPointTransaction['time'], $dateTimeZone))
            ->setSum($moneyParser->parse((string)$arPointTransaction['sum'], $currency->getCode()))
            ->setType($arPointTransaction['type'] === 0 ? Type\Fabric::getRefund() : Type\Fabric::getSale())
            ->setAuthor((string)$arPointTransaction['author'])
            ->setDescription((string)$arPointTransaction['description'])
            ->setDocumentId(new DocumentId((string)$arPointTransaction['doc_id']))
            ->setCashRegisterId(new CashRegisterId((string)$arPointTransaction['kkm_id']))
            ->setShopId(new ShopId((string)$arPointTransaction['shop_id']))
            ->setDocumentTypeId((string)$arPointTransaction['doc_type'])
            ->setInvalidatePeriod(DateTimeParser::parseTimestampFromServerResponse((string)$arPointTransaction['invalidate_period'], $dateTimeZone))
            ->setActivationPeriod(DateTimeParser::parseTimestampFromServerResponse((string)$arPointTransaction['activation_period'], $dateTimeZone))
            ->setDiscountId(new DiscountId((string)$arPointTransaction['discount_id']));

        return $pointTrx;
    }
}
