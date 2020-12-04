<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Balance;

use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;
use Rarus\BonusServer\Articles\DTO\Article;
use Rarus\BonusServer\Articles\DTO\ArticleCollection;
use Rarus\BonusServer\Articles\DTO\ArticleId;
use Rarus\BonusServer\Cards\DTO\Level\LevelId;
use Rarus\BonusServer\Cards;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Cards\DTO\Balance
 */
class Fabric
{
    /**
     * @param array    $arBalanceInfo
     * @param Currency $currency
     *
     * @return Balance
     */
    public static function initFromServerResponse(Currency $currency, array $arBalanceInfo): Balance
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return (new Balance())
            ->setAvailable($moneyParser->parse((string)$arBalanceInfo['balance_available'], $currency->getCode()))
            ->setTotal($moneyParser->parse((string)$arBalanceInfo['balance'], $currency->getCode()));
    }

    /**
     * @param Currency $currency
     * @param array    $arPaymentBalance
     *
     * @return PaymentBalance
     */
    public static function initPaymentBalanceFromServerResponse(Currency $currency, array $arPaymentBalance): PaymentBalance
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        $paymentBalance = new PaymentBalance();

        $paymentBalance
            ->setCardLevelId(new LevelId((string)$arPaymentBalance['card_level_id']))
            ->setAvailableBalance($moneyParser->parse((string)$arPaymentBalance['balance_available'], $currency->getCode()));

        if ($arPaymentBalance['max_payment'] === 0) {
            $paymentBalance->setPaymentBalance($paymentBalance->getAvailableBalance());
        } else {
            $paymentBalance->setPaymentBalance($moneyParser->parse((string)$arPaymentBalance['max_payment'], $currency->getCode()));
        }

        if ($arPaymentBalance['master_card_id'] !== '') {
            $paymentBalance->setMastercardId(new Cards\DTO\CardId((string)$arPaymentBalance['master_card_id']));
        }

        // Массив идентификаторов товаров в чеке, которые нельзя оплачивать бонусами
        if (!empty($arPaymentBalance['excluded_articles'])) {
            $articleCollection = new ArticleCollection();
            foreach ($arPaymentBalance['excluded_articles'] as $excludedArticle) {
                $article = new Article(new ArticleId($excludedArticle), '');
                $articleCollection->attach($article);
            }
            $paymentBalance->setExcludedArticleId($articleCollection);
        }

        // Массив распределений баллов оплаты по чеку
        if (!empty($arPaymentBalance['payment_distribution'])) {
            $paymentDistributionCollection = new Cards\DTO\PaymentDistribution\PaymentDistributionCollection();
            foreach ($arPaymentBalance['payment_distribution'] as $item) {
                $paymentDistribution = new Cards\DTO\PaymentDistribution\PaymentDistribution(
                    $item['line_number'],
                    new ArticleId($item['article']),
                    $moneyParser->parse((string)$item['summ'], $currency->getCode()),
                    (float)$item['max_payment_percent'],
                    (float)$item['max_payment_sum'],
                    $moneyParser->parse((string)$item['payment_sum'], $currency->getCode())
                );
                $paymentDistributionCollection->attach($paymentDistribution);
            }
            $paymentBalance->setPaymentDistributionCollection($paymentDistributionCollection);
        }

        return $paymentBalance;
    }
}
