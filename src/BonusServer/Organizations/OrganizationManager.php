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

        $arApiResponse = $this->apiClient->executeApiRequest('/organization/calculate', 'POST', [
            'body' => json_encode($arChequeItems)
        ]);

        $obItems = new \SplObjectStorage();
        /**
         * @var array $arApiResponse
         */
        foreach ($arApiResponse['cheque_items'] as $cnt => $arChequeItem)
        {
            $obItems->attach(new ChequeItem($arChequeItem));
        }

        $obItems->rewind();

        $obDiscounts = new \SplObjectStorage();
        /**
         * @var array $arApiResponse
         */
        foreach ($arApiResponse['cheque_discounts'] as $cnt => $arDiscount)
        {
            $obDiscounts->attach(new ChequeDiscount($arDiscount));
        }

        $obDiscounts->rewind();

        return new DicountCalculateDocument($obItems, $obDiscounts);
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