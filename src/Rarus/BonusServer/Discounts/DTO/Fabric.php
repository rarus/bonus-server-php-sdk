<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use Money\Currency;
use Rarus\BonusServer\Discounts;

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

        return $est;
    }
}
