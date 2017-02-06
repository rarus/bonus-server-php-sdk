<?php
namespace Rarus\BonusServer\User;

use Rarus\BonusServer\ApiClientInterface;
use Rarus\BonusServer\Exceptions\BonusServerException;
use Rarus\BonusServer\User\User;
use Rarus\BonusServer\User\UserInterface;
/**
 * Class UserManager
 * @package Rarus\BonusServer\User
 */
class UserManager
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
     *
     * @return UserInterface
     */
    public function getUser()
    {
        $arApiResponse = $this->apiClient->executeApiRequest(sprintf('/user'), 'GET');
        return new User($arApiResponse['user']);
    }

    public function Add($arUser)
    {
        if(!is_array($arUser))
        {
            throw new BonusServerException('user fields empty');
        }

        $arApiResponse = $this->apiClient->executeApiRequest('/user/new', 'POST', ['body' => json_encode($arUser)]);
        return $arApiResponse;
    }

    public function SendConfirmationCode($login)
    {
        if(strlen($login) <= 0)
        {
            throw new BonusServerException('user login is empty');
        }
        $arApiResponse = $this->apiClient->executeApiRequest('/user/sign_in/send_confirmation_code', 'POST', ['body' => json_encode([
            'login' => $login,
            'company_id' => 3
        ])]);
        return $arApiResponse;

    }

    /**
     * @param $arUser
     * @return array
     * @throws BonusServerException
     */
    public function Update($arUser)
    {
        /*$arUser = array(
            "name" => "Сергей",
            "phone" => "1111111",
            "email" => "mors@rarus.ru",
            "gender" => "male",
            "birthday" => 12312312,
            "receive_notifications" => true
        );*/
        if(!is_array($arUser))
        {
            throw new BonusServerException('user fields empty');
        }
        //$arApiResponse = $this->apiClient->executeApiRequest(sprintf('/user/update'), 'PUT', $arUser);
        $arApiResponse = $this->apiClient->executeApiRequest('/user/update', 'PUT', ['body' => json_encode($arUser)]);
        return $arApiResponse;


    }
}

?>