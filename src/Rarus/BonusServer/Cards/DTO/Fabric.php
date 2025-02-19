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
     * @param array         $arCard
     * @param Currency      $currency
     * @param \DateTimeZone $dateTimeZone
     *
     * @return Card
     * @throws \Rarus\BonusServer\Exceptions\ApiClientException
     */
    public static function initCardFromServerResponse(array $arCard, \Money\Currency $currency, \DateTimeZone $dateTimeZone): Card
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        $card = (new Card())
            ->setCardId(new CardId($arCard['id']))
            ->setName((string)$arCard['name'])
            ->setBarcode(new Barcode\Barcode((string)$arCard['barcode']))
            ->setCode((string)$arCard['code'])
            ->setDescription((string)$arCard['description'])
            ->setCardStatus(Status\Fabric::initFromServerResponse($arCard, $dateTimeZone));

        if (key_exists('parent_id', $arCard)) {
            $card->setParentId(new CardId($arCard['parent_id']));
        }
        if (key_exists('card_level_id', $arCard)) {
            $card->setCardLevelId(new LevelId((string)$arCard['card_level_id']));
        }
        if (key_exists('accum_sale_amount', $arCard)) {
            $card->setAccumSaleAmount($moneyParser->parse((string)$arCard['accum_sale_amount'], $currency));
        }
        if (key_exists('date_last_transaction', $arCard) && $arCard['date_last_transaction'] !== 0) {
            $card->setDateLastTransaction(DateTimeParser::parseTimestampFromServerResponse((string)$arCard['date_last_transaction'], $dateTimeZone));
        }
        if (key_exists('last_transaction', $arCard) && $arCard['last_transaction'] !== '') {
            $card->setLastTransaction((string)$arCard['last_transaction']);
        }
        if (key_exists('user_id', $arCard) && $arCard['user_id'] !== '') {
            $card->setUserId(new UserId($arCard['user_id']));
        }

        return $card;
    }

    /**
     * @param string       $code
     * @param string       $barcode
     * @param Currency     $currency
     * @param null|LevelId $defaultCardLevelId
     *
     * @return Card
     */
    public static function createNewInstance(string $code, string $barcode, Currency $currency, ?LevelId $defaultCardLevelId = null): Card
    {
        $card = (new Card())
            ->setCode($code)
            ->setBarcode(new Barcode\Barcode($barcode))
            ->setAccumSaleAmount(new Money('0', $currency))
            ->setCardStatus(Status\Fabric::initDefaultStatusForNewCard());

        if ($defaultCardLevelId instanceof LevelId) {
            $card->setCardLevelId($defaultCardLevelId);
        }

        return $card;
    }
}
