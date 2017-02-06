<?php
namespace Rarus\BonusServer\Card;

use Rarus\BonusServer\ApiClientInterface;
use Rarus\BonusServer\Card;
use Rarus\BonusServer\BonusServerResponse;
use Rarus\BonusServer\Exceptions\BonusServerException;

/**
 * Class CardManager
 * @package Rarus\BonusServer\Card
 */
class CardManager
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
     * @param string $name
     * @param string $description
     * возможность добавления зависит от
     * настроек организации, к которой
     * привязан текущий пользователь
     */
    public function Add($name = '', $description = '')
    {
        $arApiResponse = $this->apiClient->executeApiRequest('/user/card/add', 'POST', [
            'body' => json_encode([
                'name' => $name,
                'description' => $description
            ])
        ]);

        return new Card\Card($arApiResponse['card']);
        //return $arApiResponse;
    }

    /**
     * @param $bar_code
     * @return bool
     */
    public function Attach($barCode)
    {
        if(strlen($barCode) <= 0)
        {
            throw new BonusServerException('empty card barcode');
        }
        $arApiResponse = $this->apiClient->executeApiRequest('/user/card/attach', 'POST', [
            'body' => json_encode([
                'barcode' => $barCode
            ])
        ]);

        return $arApiResponse;
    }

    /**
     * @param $barCode
     * @param $confirmCode - код подтверждения живет около 60 сек
     * после запроса привязки карты методом CardManager->Attach()
     * @return null|string
     * @throws BonusServerException
     */
    public function Confirm($barCode,$confirmCode)
    {
        if(strlen($barCode) <= 0)
        {
            throw new BonusServerException('empty card barcode');
        }
        if(strlen($confirmCode) <= 0)
        {
            throw new BonusServerException('empty confirm code');
        }
        $arApiResponse = $this->apiClient->executeApiRequest('/user/card/attach/confirm', 'POST', [
            'body' => json_encode([
                'barcode' => $barCode,
                'code' => $confirmCode
            ])
        ]);

        return $arApiResponse;
    }


    /**
     * @return \Rarus\BonusServer\BonusServerResponse\BonusServerResponse
     */
    public function getUserCardsList($page = 1, $perPage = 50)
    {
        if((int)$page <= 0)
        {
            $page = 1;
        }
        if((int)$perPage <= 0)
        {
            $perPage = 50;
        }
        $arApiResponse = $this->apiClient->executeApiRequest(sprintf('/user/card/get_list?page='.$page.'&per_page='.$perPage), 'GET');
        $obResult = new \SplObjectStorage();
        foreach($arApiResponse['cards'] as $cnt => $arCardItem)
        {
            $obResult->attach(new Card\Card($arCardItem));
        }
        $obResult->rewind();

        return new BonusServerResponse\BonusServerResponse($obResult, $arApiResponse["pagination"]);
    }

    /**
     * @param $cardId
     * @param bool $cntLastTransactions
     * @return null|string
     * @throws BonusServerException
     */
    public function GetCardBalance($cardId, $cntLastTransactions = false)
    {
        if(strlen($cardId) <= 0) {
            throw new BonusServerException('empty card id');
        }
        $requestStr = '/user/card/'.$cardId.'/balance_info';
        if((int)$cntLastTransactions > 0)
        {
            $requestStr .= '?last_transactions='.(int)$cntLastTransactions;
        }
        $arApiResponse = $this->apiClient->executeApiRequest((sprintf($requestStr)), 'GET');
        return $arApiResponse;
    }
}

?>