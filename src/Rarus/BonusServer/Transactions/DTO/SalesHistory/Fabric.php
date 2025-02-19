<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\SalesHistory;

use Money\Currency;
use Money\Money;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Util\DateTimeParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Operations
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array $arResponse
     * @param \DateTimeZone $dateTimeZone
     * @return HistoryItem
     * @throws ApiClientException
     */
    public static function initHistoryItemFromServerResponse(Currency $currency, array $arResponse, \DateTimeZone $dateTimeZone): HistoryItem
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        $productRowCollection = new Transactions\DTO\Products\ProductRowCollection();
        foreach ($arResponse['cheque_items_for_sales'] as $arProductRow) {
            $productRowCollection->attach(Transactions\DTO\Products\Fabric::initProductRowFromServerResponse($currency, $arProductRow));
        }

        $operation = new HistoryItem();
        $operation
            ->setLineNumber((int)$arResponse['row_number'])
            ->setDate(DateTimeParser::parseTimestampFromServerResponse((string)$arResponse['date'], $dateTimeZone))
            ->setDocumentId(new DocumentId((string)$arResponse['doc_id']))
            ->setCardId(new CardId((string)$arResponse['card_id']))
            ->setShopId(new ShopId((string)$arResponse['shop_id']))
            ->setCashRegisterId(new CashRegisterId((string)$arResponse['cashbox_id']))
            ->setChequeId(new ChequeId((string)$arResponse['check_number']))
            ->setSum($moneyParser->parse((string)$arResponse['summ'], $currency))
            ->setSumWithDiscount($moneyParser->parse((string)$arResponse['summ_with_discount'], $currency))
            ->setBonusEarned((float)$arResponse['bonus_earned'])
            ->setBonusSpent((float)$arResponse['bonus_spent'])
            ->setType(Transactions\DTO\Type\Fabric::initFromServerResponse((string)$arResponse['operation']))
            ->setProducts($productRowCollection);

        if ($arResponse['date_calculate_local'] !== 0) {
            $operation->setDateCalculate(DateTimeParser::parseTimestampFromServerResponse((string)$arResponse['date_calculate_local'], $dateTimeZone));
        }

        return $operation;
    }
}
