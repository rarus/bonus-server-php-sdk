<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO\DocumentItems;

use Money\Currency;
use Money\Money;
use Rarus\BonusServer\Articles\DTO\ArticleId;
use Rarus\BonusServer\Discounts\DTO\Bonuses\Bonus;

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
            ->setSum(new Money((int)$documentItem['bonus_summ'], $currency))
            ->setPercent((float)$documentItem['bonus_percet']);

        $item
            ->setLineNumber((int)$documentItem['line_number'])
            ->setArticleId(new ArticleId($documentItem['article']))
            ->setQuantity((int)$documentItem['quantity'])
            ->setPrice(new Money((int)$documentItem['price'], $currency))
            ->setSum(new Money((int)$documentItem['summ'], $currency))
            ->setBonus($bonus);

        return $item;
    }
}