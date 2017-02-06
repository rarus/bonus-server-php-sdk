<?php
namespace Rarus\BonusServer\Auth;

class Token implements TokenInterface
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
     * Token constructor.
     *
     * @param $arAuthToken
     */
    public function __construct($arAuthToken)
    {
        $this->setCode($arAuthToken['code']);
        $this->setMessage($arAuthToken['message']);
        $this->setToken($arAuthToken['token']);
        $this->setCompanyId($arAuthToken['company_id']);
        $this->setExpires($arAuthToken['expires']);
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param int $companyId
     */
    protected function setCompanyId($companyId)
    {
        $this->companyId = (int)$companyId;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    protected function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param int $expires
     */
    protected function setExpires($expires)
    {
        $this->expires = (int)$expires;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    protected function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    protected function setCode($code)
    {
        $this->code = (int)$code;
    }
}