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
    public function getUserList($page = 1,$perPage = 50)
    {
        if((int)$page <= 0)
        {
            $page = 1;
        }
        if((int)$perPage <= 0)
        {
            $perPage = 50;
        }
        $arApiResponse = $this->apiClient->executeApiRequest(sprintf('/organization/user'), 'GET');
        $obResult = new \SplObjectStorage();
        /**
         * @var array $arApiResponse
         */
        foreach ($arApiResponse['users'] as $cnt => $arUser)
        {
            $obResult->attach(new User($arUser));
        }
        $obResult->rewind();
        return $obResult;
    }

    /**
     * @param $arCardParams
     * @return \SplObjectStorage
     */
    public function getCardList($arCardParams)
    {
        $paramsStr = "";
        if(!isset($arCardParams['page']))
        {
            $arCardParams['page'] = 1;
        }
        if(!isset($arCardParams['per_page']))
        {
            $arCardParams['per_page'] = 100;
        }
        if(is_array($arCardParams) && count($arCardParams) > 0)
        {
            $i = 0;
            foreach($arCardParams as $paramCode => $paramVal)
            {
                ($i==0) ? ($paramsStr = '?'.$paramCode.'='.$paramVal) : $paramsStr .= '&'.$paramCode.'='.$paramVal;
                $i++;
            }
        }

        $arApiResponse = $this->apiClient->executeApiRequest(sprintf('/organization/card'.$paramsStr), 'GET');
        
        $obResult = new \SplObjectStorage();
        /**
         * @var array $arApiResponse
         */
        foreach ($arApiResponse['cards'] as $cnt => $arCard)
        {
            $obResult->attach(new Card($arCard));
        }
        $obResult->rewind();
        return $obResult;

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
//            "card_id" => "1cd20b45-cff8-4c58-82fc-4341a3a7bcf3",
//            "card_code" => "test_card",
//            "card_barcode" => "1429816",
//            "shop_id" => "",
//            "cheque_items" => [
//                [
//                    "line_number" => 1,
//                    "article" => "12456",
//                    "quantity" => 1.000,
//                    "price" => 1.99,
//                    "discount_summ" => 1.90,
//                   "summ"         => 100,99,
//                   "bonus_percet" => 40,
//                   "bonus_summ"   => 12
//
//                ],
//                [
//                    "line_number" => 2,
//                    "article" => "35892",
//                    "quantity" => 1.000,
//                    "price" => 1.99,
//                    "discount_summ" => 1.90,
//                   "summ"         => 100,99,
//                   "bonus_percet" => 40,
//                   "bonus_summ"   => 12
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

        //return $arApiResponse;
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