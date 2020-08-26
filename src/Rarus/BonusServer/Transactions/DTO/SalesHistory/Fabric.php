<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\SalesHistory;

use Money\Currency;
use Money\Money;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Operations
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $arResponse
     *
     * @return HistoryItem
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initHistoryItemFromServerResponse(Currency $currency, array $arResponse): HistoryItem
    {
        $operationDate = new \DateTime();
        $operationDate->setTimestamp((int)$arResponse['date']);

        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        $productRowCollection = new Transactions\DTO\Products\ProductRowCollection();
        foreach ($arResponse['cheque_items_for_sales'] as $arProductRow) {
            $productRowCollection->attach(Transactions\DTO\Products\Fabric::initProductRowFromServerResponse($currency, $arProductRow));
        }

        $operation = new HistoryItem();
        $operation
            ->setLineNumber((int)$arResponse['row_number'])
            ->setDate($operationDate)
            ->setDocumentId(new DocumentId((string)$arResponse['doc_id']))
            ->setCardId(new CardId((string)$arResponse['card_id']))
            ->setShopId(new ShopId((string)$arResponse['shop_id']))
            ->setCashRegisterId(new CashRegisterId((string)$arResponse['cashbox_id']))
            ->setChequeId(new ChequeId((string)$arResponse['check_number']))
            ->setSum($moneyParser->parse((string)$arResponse['summ'], $currency->getCode()))
            ->setSumWithDiscount($moneyParser->parse((string)$arResponse['summ_with_discount'], $currency->getCode()))
            ->setType(Transactions\DTO\Type\Fabric::initFromServerResponse((string)$arResponse['operation']))
            ->setProducts($productRowCollection);

        if ($arResponse['date_calculate_local'] !== 0) {
            $operationDate = new \DateTime();
            $operationDate->setTimestamp((int)$arResponse['date_calculate_local']);
            $operation->setDateCalculate($operationDate);
        }

        return $operation;
    }
}
