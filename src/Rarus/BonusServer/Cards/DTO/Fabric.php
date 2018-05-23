<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO;

use Money\Money;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Cards\DTO
 */
class Fabric
{
    /**
     * @param array    $arCard
     * @param Currency $currency
     *
     * @return Card
     */
    public static function initCardFromServerResponse(array $arCard, \Money\Currency $currency): Card
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        $card = (new Card())
            ->setCardId(new CardId($arCard['id']))
            ->setParentId(new CardId($arCard['parent_id']))
            ->setName((string)$arCard['name'])
            ->setBarcode((string)$arCard['barcode'])
            ->setCode((string)$arCard['barcode'])
            ->setDescription((string)$arCard['description'])
            ->setAccumSaleAmount($moneyParser->parse((string)$arCard['accum_sale_amount'], $currency->getCode()))
            ->setCardStatus(Status\Fabric::initFromServerResponse($arCard));

        if ($arCard['date_last_transaction'] !== 0) {
            $card->setDateLastTransaction(\DateTime::createFromFormat('U', (string)$arCard['date_last_transaction']));
        }
        if ($arCard['last_transaction'] !== '') {
            $card->setLastTransaction((string)$arCard['last_transaction']);
        }

        return $card;
    }

    /**
     * @param string          $code
     * @param string          $barcode
     * @param \Money\Currency $currency
     *
     * @return Card
     */
    public static function createNewInstance(string $code, string $barcode, Currency $currency): Card
    {
        $card = (new Card())
            ->setCode($code)
            ->setBarcode($barcode)
            ->setAccumSaleAmount(new Money('0', $currency))
            ->setCardStatus(\Rarus\BonusServer\Cards\DTO\Status\Fabric::initDefaultStatusForNewCard());

        return $card;
    }
}