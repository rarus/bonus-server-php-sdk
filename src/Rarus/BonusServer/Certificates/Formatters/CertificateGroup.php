<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\Formatters;


/**
 * Class CertificateGroup
 *
 * @package Rarus\BonusServer\Certificates\Formatters
 */
class CertificateGroup
{
    public static function toArrayForCreateNewCertificateGroup(
        \Rarus\BonusServer\Certificates\DTO\CertificateGroup $certificateGroup
    ): array {
        $arFormatted = [];

        if (!empty($certificateGroup->getCertificateGroupId()->getId())) {
            $arFormatted['id'] = $certificateGroup->getCertificateGroupId()->getId();
        }

        if (!empty($certificateGroup->getName())) {
            $arFormatted['name'] = $certificateGroup->getName();
        }

        if (!empty($certificateGroup->getDescription())) {
            $arFormatted['description'] = $certificateGroup->getDescription();
        }

        if (!empty($certificateGroup->getStartDate())) {
            $arFormatted['start_date'] = $certificateGroup->getStartDate()->getTimestamp();
        }

        if (!empty($certificateGroup->getEndDate())) {
            $arFormatted['end_date'] = $certificateGroup->getEndDate()->getTimestamp();
        }

        if (!empty($certificateGroup->getStartSaleDate())) {
            $arFormatted['start_sale_date'] = $certificateGroup->getStartSaleDate()->getTimestamp();
        }

        if (!empty($certificateGroup->getEndSaleDate())) {
            $arFormatted['end_sale_date'] = $certificateGroup->getEndSaleDate()->getTimestamp();
        }

        if (!empty($certificateGroup->getPeriodType())) {
            $arFormatted['period_type'] = $certificateGroup->getPeriodType();
        }

        if (!empty($certificateGroup->getUseDays())) {
            $arFormatted['use_days'] = $certificateGroup->getUseDays();
        }

        if (!empty($certificateGroup->getValue())) {
            $arFormatted['value'] = $certificateGroup->getValue();
        }

        if (!empty($certificateGroup->getUseMethod())) {
            $arFormatted['use_method'] = $certificateGroup->getUseMethod();
        }

        if (!empty($certificateGroup->isDeleted())) {
            $arFormatted['deleted'] = $certificateGroup->isDeleted();
        }

        if (!empty($certificateGroup->getIncludeShopItems())) {
            foreach ($certificateGroup->getIncludeShopItems() as $includeShopItem) {
                $arFormatted['include_shop_items'][] = $includeShopItem->getId();
            }
        }

        if (!empty($certificateGroup->getExcludeShopItems())) {
            foreach ($certificateGroup->getExcludeShopItems() as $excludeShopItem) {
                $arFormatted['exclude_shop_items'][] = $excludeShopItem->getId();
            }
        }

        return $arFormatted;
    }
}
