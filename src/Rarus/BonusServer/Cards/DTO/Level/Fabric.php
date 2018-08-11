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
            ->setLevelId(new LevelId($arLevel['level_id']))
            ->setName($arLevel['level_name'])
            ->setAccumAmount($moneyParser->parse((string)$arLevel['accum_amount'], $currency->getCode()))
            ->setAccumLevel($moneyParser->parse((string)$arLevel['accum_level'], $currency->getCode()));
    }
}