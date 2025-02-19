<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Level;

use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Cards\DTO\Level
 */
class Fabric
{
    /**
     * @param array    $arLevel
     * @param Currency $currency
     *
     * @return Level
     */
    public static function initFromServerResponse(array $arLevel, Currency $currency): Level
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return (new Level())
            ->setRowNumber((int)$arLevel['row_number'])
            ->setLevelId(new LevelId((string)$arLevel['id']))
            ->setName((string)$arLevel['name'])
            ->setOrder((int)$arLevel['order'])
            ->setAccumulationAmountToNextLevel($moneyParser->parse((string)$arLevel['accum_level'], $currency))
            ->setResetAccumulationSumWhenUpgradeLevel((bool)$arLevel['reset_card_accum'])
            ->setMaxPaymentPercent((int)$arLevel['max_payment_percent'])
            ->setRestrictionRule(new RestrictionRule(
                (int)$arLevel['activity_restriction_period'],
                (int)$arLevel['activity_restriction_count'],
                (int)$arLevel['inactivity_bonus_erase_period']
            ));
    }

    /**
     * @param array    $arLevelDescription
     * @param Currency $currency
     *
     * @return LevelDescription
     */
    public static function initLevelDescriptionFromServerResponse(array $arLevelDescription, Currency $currency): LevelDescription
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return (new LevelDescription())
            ->setLevelId(new LevelId($arLevelDescription['level_id']))
            ->setName($arLevelDescription['level_name'])
            ->setLevelUpAccumulationSum($moneyParser->parse((string)$arLevelDescription['accum_level'], $currency))
            ->setCardAccumulationSum($moneyParser->parse((string)$arLevelDescription['accum_amount'], $currency));
    }
}
