<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO\DocumentItems;

use Money\Currency;
use Rarus\BonusServer\Articles\DTO\ArticleId;
use Rarus\BonusServer\Discounts\DTO\Bonuses\Bonus;
use Rarus\BonusServer\Util\MoneyParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Discounts\DTO\DocumentItems
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $documentItem
     *
     * @return DocumentItem
     */
    public static function initFromServerResponse(Currency $currency, array $documentItem): DocumentItem
    {
        $item = new DocumentItem();
        $bonus = new Bonus();

        $bonus
            ->setSum(MoneyParser::parseFloat($documentItem['bonus_summ'], $currency))
            ->setPercent((float)$documentItem['bonus_percet']);

        $item
            ->setLineNumber((int)$documentItem['line_number'])
            ->setArticleId(new ArticleId($documentItem['article']))
            ->setQuantity((int)$documentItem['quantity'])
            ->setPrice(MoneyParser::parseFloat($documentItem['price'], $currency))
            ->setSum(MoneyParser::parseFloat($documentItem['summ'], $currency))
            ->setBonus($bonus);

        return $item;
    }
}
