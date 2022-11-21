<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use Money\Currency;
use Rarus\BonusServer\Articles\DTO\ArticleId;
use Rarus\BonusServer\Cards\DTO\PaymentDistribution\PaymentDistribution;
use Rarus\BonusServer\Cards\DTO\PaymentDistribution\PaymentDistributionCollection;
use Rarus\BonusServer\Discounts;
use Rarus\BonusServer\Util\MoneyParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Discounts\DTO
 */
class Fabric
{
    /**
     * @param Currency $currency
     * @param array    $arEstimate
     *
     * @return Estimate
     */
    public static function initEstimateFromServerResponse(Currency $currency, array $arEstimate): Estimate
    {
        $est = new Estimate();

        $documentItemCollection = new Discounts\DTO\DocumentItems\DocumentItemCollection();
        foreach ($arEstimate['cheque_items'] as $chequeItem) {
            $documentItemCollection->attach(Discounts\DTO\DocumentItems\Fabric::initFromServerResponse($currency, $chequeItem));
        }
        $est->setDocumentItems($documentItemCollection);

        $discountItemCollection = new Discounts\DTO\DiscountItems\DiscountItemCollection();
        foreach ($arEstimate['cheque_bonus'] as $discountItem) {
            $discountItemCollection->attach(Discounts\DTO\DiscountItems\Fabric::initFromServerResponse($currency, $discountItem));
        }
        $est->setDiscountItems($discountItemCollection);

        if(!empty($arEstimate['payment_distribution'])) {
            $paymentDistributionCollection = new PaymentDistributionCollection();
            foreach ($arEstimate['payment_distribution'] as $item) {
                $paymentDistribution = new PaymentDistribution(
                    $item['line_number'],
                    new ArticleId($item['article']),
                    MoneyParser::parseFloat((string)$item['summ'], $currency),
                    (float)$item['max_payment_percent'],
                    (float)$item['max_payment_sum'],
                    MoneyParser::parseFloat((string)$item['payment_sum'], $currency)
                );
                $paymentDistributionCollection->attach($paymentDistribution);
            }
            $est->setPaymentDistributionCollection($paymentDistributionCollection);
        }

        if (!empty($arEstimate['max_payment'])) {
            $est->setMaxPayment((int)$arEstimate['max_payment']);
        }

        return $est;
    }
}
