<?php

namespace Rarus\BonusServer\Auth\DTO;

/**
 * Class AuthToken
 *
 * @package Rarus\BonusServer\Auth\AuthToken
 */
class AuthToken
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var int
     */
    protected $expires;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var int
     */
    protected $companyId;

    /**
     * AuthToken constructor.
     *
     * @param $code
     * @param $message
     * @param $token
     * @param $companyId
     * @param $expires
     */
    public function __construct($code, $message, $token, $companyId, $expires)
    {
        $this->code = (int)$code;
        $this->message = $message;
        $this->token = $token;
        $this->companyId = $companyId;
        $this->expires = $expires;
    }

    /**
     * @param array $arAuthToken
     *
     * @return AuthToken
     */
    public static function initFromArray(array $arAuthToken)
    {
        return new self(
            (int)$arAuthToken['code'],
            $arAuthToken['message'],
            $arAuthToken['token'],
            $arAuthToken['company_id'],
            $arAuthToken['expires']
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'token' => $this->getToken(),
            'company_id' => $this->getCompanyId(),
            'expires' => $this->getExpires(),
        ];
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->expires;
    }
}
