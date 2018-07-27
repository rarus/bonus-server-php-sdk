<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Points;

use Money\Currency;
use Money\Money;
use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Discounts\DTO\DiscountId;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Transactions\DTO\CashRegister\CashRegisterId;
use Rarus\BonusServer\Transactions\DTO\Document\DocumentId;
use Rarus\BonusServer\Transactions\DTO\Type;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Points
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $arPointTransaction
     *
     * @return PointTransaction
     */
    public static function initPointTransactionFromServerResponse(Currency $currency, array $arPointTransaction): PointTransaction
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        $pointTrx = new PointTransaction();
        $pointTrx
            ->setRowNumber((int)$arPointTransaction['row_number'])
            ->setPointId(new PointId((string)$arPointTransaction['id']))
            ->setCardId(new CardId((string)$arPointTransaction['card_id']))
            ->setMastercardId(new CardId((string)$arPointTransaction['mastercard_id']))
            ->setTime(\DateTime::createFromFormat('U', (string)$arPointTransaction['time']))
            ->setSum($moneyParser->parse((string)$arPointTransaction['sum'], $currency->getCode()))
            ->setType($arPointTransaction['type'] === 0 ? Type\Fabric::getRefund() : Type\Fabric::getSale())
            ->setAuthor((string)$arPointTransaction['author'])
            ->setDescription((string)$arPointTransaction['description'])
            ->setDocumentId(new DocumentId((string)$arPointTransaction['doc_id']))
            ->setCashRegisterId(new CashRegisterId((string)$arPointTransaction['kkm_id']))
            ->setShopId(new ShopId((string)$arPointTransaction['shop_id']))
            ->setDocumentTypeId((string)$arPointTransaction['doc_type'])
            ->setInvalidatePeriod(\DateTime::createFromFormat('U', (string)$arPointTransaction['invalidate_period']))
            ->setActivationPeriod(\DateTime::createFromFormat('U', (string)$arPointTransaction['activation_period']))
            ->setDiscountId(new DiscountId((string)$arPointTransaction['discount_id']));

        return $pointTrx;
    }
}