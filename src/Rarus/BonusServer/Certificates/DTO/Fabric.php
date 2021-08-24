<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\DTO;


use Money\Currency;
use Rarus\BonusServer\Certificates\DTO\ExcludeShopItems\ExcludeShopItem;
use Rarus\BonusServer\Certificates\DTO\ExcludeShopItems\ExcludeShopItemCollection;
use Rarus\BonusServer\Certificates\DTO\IncludeShopItems\IncludeShopItem;
use Rarus\BonusServer\Certificates\DTO\IncludeShopItems\IncludeShopItemCollection;
use Rarus\BonusServer\Shops\DTO\ShopId;
use Rarus\BonusServer\Util\MoneyParser;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Certificates\DTO
 */
class Fabric
{
    /**
     * @param \Money\Currency $currency
     * @param array           $arCertificate
     *
     * @return \Rarus\BonusServer\Certificates\DTO\Certificate
     */
    public static function initCertificateFromServerResponse(Currency $currency, array $arCertificate): Certificate
    {
        $certificate = new Certificate(new CertificateId($arCertificate['id']));

        if (!empty($arCertificate['group_id'])) {
            $certificateGroup = new CertificateGroup();
            $certificateGroup->setId(new CertificateGroupId($arCertificate['group_id']));
            $certificate->setCertificateGroup($certificateGroup);
        }

        if (!empty($arCertificate['description'])) {
            $certificate->setDescription($arCertificate['description']);
        }

        if (!empty($arCertificate['status'])) {
            $certificate->setStatus((int)$arCertificate['status']);
        }

        if (!empty($arCertificate['status_date'])) {
            $certificate->setStatusDate((new \DateTime())->setTimestamp($arCertificate['status_date']));
        }

        if (!empty($arCertificate['status_description'])) {
            $certificate->setStatusDescription($arCertificate['status_description']);
        }

        if (!empty($arCertificate['activation_date'])) {
            $certificate->setActivationDate((new \DateTime())->setTimestamp($arCertificate['activation_date']));
        }

        $certificate
            ->setValue((int)$arCertificate['value'])
            ->setNominal((float)$arCertificate['nominal'])
            ->setBalance(MoneyParser::parseFloat($arCertificate['balance'], $currency));

        if (!empty($arCertificate['certificate_group'])) {
            $certificateGroup = self::initCertificateGroupFromServerResponse($arCertificate['certificate_group']);
            $certificate->setCertificateGroup($certificateGroup);
        }

        return $certificate;
    }

    /**
     * @param array $arrCertificateGroup
     *
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroup
     */
    public static function initCertificateGroupFromServerResponse(array $arrCertificateGroup): CertificateGroup
    {
        $certificateGroup = new CertificateGroup();

        $includeShopItems = new IncludeShopItemCollection();
        $excludeShopItems = new ExcludeShopItemCollection();

        if (!empty($arrCertificateGroup['include_shop_items'])) {
            foreach ($arrCertificateGroup['include_shop_items'] as $include_shop_item) {
                $includeShopItems->attach(
                    new IncludeShopItem(
                        new ShopId($include_shop_item['id']),
                        $include_shop_item['name']
                    )
                );
            }
        }

        if (!empty($arrCertificateGroup['exclude_shop_items'])) {
            foreach ($arrCertificateGroup['exclude_shop_items'] as $exclude_shop_item) {
                $excludeShopItems->attach(
                    new ExcludeShopItem(
                        new ShopId($exclude_shop_item['id']),
                        $exclude_shop_item['name']
                    )
                );
            }
        }

        $certificateGroup
            ->setRowNumber($arrCertificateGroup['row_number'])
            ->setId(new CertificateGroupId($arrCertificateGroup['id']))
            ->setName((string)$arrCertificateGroup['name'])
            ->setDescription((string)$arrCertificateGroup['description'])
            ->setStartDate((new \DateTime())->setTimestamp($arrCertificateGroup['start_date']))
            ->setEndDate((new \DateTime())->setTimestamp($arrCertificateGroup['end_date']))
            ->setStartSaleDate((new \DateTime())->setTimestamp($arrCertificateGroup['start_sale_date']))
            ->setEndSaleDate((new \DateTime())->setTimestamp($arrCertificateGroup['end_sale_date']))
            ->setPeriodType((int)$arrCertificateGroup['period_type'])
            ->setUseDays((int)$arrCertificateGroup['use_days'])
            ->setValue((float)$arrCertificateGroup['value'])
            ->setUseMethod((int)$arrCertificateGroup['use_method'])
            ->setDeleted((bool)$arrCertificateGroup['deleted'])
            ->setIncludeShopItems($includeShopItems)
            ->setExcludeShopItems($excludeShopItems);

        return $certificateGroup;
    }
}
