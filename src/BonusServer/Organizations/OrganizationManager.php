<?php
namespace Rarus\BonusServer\Organizations;

use Rarus\BonusServer\ApiClientInterface;
use Rarus\BonusServer\Organizations\SettingsItemInterface;
use Rarus\BonusServer\Organizations\SettingsItem;
use Rarus\BonusServer\User\User;
use Rarus\BonusServer\Card\Card;
use Rarus\BonusServer\Exceptions\BonusServerException;

/**
 * Class OrganizationManager
 *
 * @package Rarus\BonusServer\Organizations
 */
class OrganizationManager
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    public function __construct(ApiClientInterface $obApiClient)
    {
        $this->apiClient = $obApiClient;
    }

    /**
     * @return OrganizationInterface
     */
    public function get()
    {
        $result = $this->apiClient->executeApiRequest(sprintf('/organization'), 'GET');
        return new Organization($result['organization']);
    }

    /**
     *
     * @return \SplObjectStorage
     */
    public function getSettings()
    {
        $arApiResponse = $this->apiClient->executeApiRequest(sprintf('/organization/settings'), 'GET');
        $obResult = new \SplObjectStorage();
        /**
         * @var array $arApiResponse
         */
        foreach ($arApiResponse['settings'] as $cnt => $arSettingsItem)
        {
            $obResult->attach(new SettingsItem($arSettingsItem));
        }
        $obResult->rewind();
        return $obResult;
    }

    /**
     * @param $cardId
     * @return Card
     */
    public function GetCardById($cardId)
    {
        if(strlen($cardId) <= 0)
        {
            throw new BonusServerException('empty cardID');
        }
        $arApiResponse = $this->apiClient->executeApiRequest(sprintf('/organization/card/'.htmlspecialchars($cardId)), 'GET');
        return new Card($arApiResponse['card']);
    }
    /**
     *
     * @return \SplObjectStorage
     */
    public function Calculate($arChequeItems)
    {
        if(!is_array($arChequeItems) || count($arChequeItems["cheque_items"]) <= 0)
        {
            throw new BonusServerException('empty cheque items');
        }
//        $arChequeItems = [
//            "card_id" => "12345678",
//            "card_code" => "AAAAA",
//            "card_barcode" => "1111111",
//            "shop_id" => "",
//            "cheque_items" => [
//                [
//                    "line_number" => 1,
//                    "article" => "123",
//                    "quantity" => 1.000,
//                    "price" => 1.99,
//                    "discount_summ" => 1.90,
//                   "summ"         => 100,99,
//                   "bonus_percet" => 10,
//                   "bonus_summ"   => 10
//
//                ],
//                [
//                    "line_number" => 2,
//                    "article" => "124",
//                    "quantity" => 1.000,
//                    "price" => 1.99,
//                    "discount_summ" => 1.90,
//                   "summ"         => 100,99,
//                   "bonus_percet" => 10,
//                   "bonus_summ"   => 10
//
//                ]
//            ]
//        ];
        $arApiResponse = $this->apiClient->executeApiRequest('/organization/calculate', 'POST', [
            'body' => json_encode($arChequeItems)
        ]);

        $obResult = new \SplObjectStorage();
        /**
         * @var array $arApiResponse
         */
        foreach ($arApiResponse['cheque_items'] as $cnt => $arChequeItem)
        {
            $obResult->attach(new ChequeItem($arChequeItem));
        }

        $obResult->rewind();

        return $obResult;
    }

    /**
     * @param $arTransactionParams
     * @return null|string
     */
    public function AddTransaction($arTransactionParams)
    {
        if(!is_array($arTransactionParams))
        {
            throw new BonusServerException('empty transactions params');
        }

        $arApiResponse = $this->apiClient->executeApiRequest('/organization/transaction/add', 'POST', [
            'body' => json_encode($arTransactionParams)
        ]);

        return $arApiResponse;
    }
}