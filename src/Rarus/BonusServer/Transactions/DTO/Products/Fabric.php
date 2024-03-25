<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Products;

use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;
use Rarus\BonusServer\Articles\DTO\ArticleId;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Products
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $arResponse
     *
     * @return ProductRow
     */
    public static function initProductRowFromServerResponse(Currency $currency, array $arResponse): ProductRow
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        $productRow = new ProductRow();

        $productRow
            ->setArticleId(new ArticleId((string)$arResponse['article_id']))
            ->setName((string)$arResponse['item_name'])
            ->setQuantity((int)$arResponse['quantity'])
            ->setPrice($moneyParser->parse((string)$arResponse['price'], $currency->getCode()))
            ->setDiscount($moneyParser->parse((string)$arResponse['discount'], $currency->getCode()));

        return $productRow;
    }
}
