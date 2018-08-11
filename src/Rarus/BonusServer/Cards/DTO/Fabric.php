<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO;

use Money\Money;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;
use Rarus\BonusServer\Cards\DTO\Level\LevelId;
use Rarus\BonusServer\Users\DTO\UserId;
use Rarus\BonusServer\Util\DateTimeParser;

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
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initCardFromServerResponse(array $arCard, \Money\Currency $currency): Card
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        $card = (new Card())
            ->setCardId(new CardId($arCard['id']))
            ->setParentId(new CardId($arCard['parent_id']))
            ->setName((string)$arCard['name'])
            ->setBarcode(new Barcode\Barcode((string)$arCard['barcode']))
            ->setCode((string)$arCard['code'])
            ->setDescription((string)$arCard['description'])
            ->setCardLevelId(new LevelId((string)$arCard['card_level_id']))
            ->setAccumSaleAmount($moneyParser->parse((string)$arCard['accum_sale_amount'], $currency->getCode()))
            ->setCardStatus(Status\Fabric::initFromServerResponse($arCard));

        if ($arCard['date_last_transaction'] !== 0) {
            $card->setDateLastTransaction(DateTimeParser::parseTimestampFromServerResponse((string)$arCard['date_last_transaction']));
        }
        if ($arCard['last_transaction'] !== '') {
            $card->setLastTransaction((string)$arCard['last_transaction']);
        }
        if ($arCard['user_id'] !== '') {
            $card->setUserId(new UserId($arCard['user_id']));
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
            ->setBarcode(new Barcode\Barcode($barcode))
            ->setAccumSaleAmount(new Money('0', $currency))
            ->setCardStatus(Status\Fabric::initDefaultStatusForNewCard());

        return $card;
    }
}