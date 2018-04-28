<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Auth\DTO;

/**
 * Class AuthToken
 *
 * @package Rarus\BonusServer\Credentials\AuthToken
 */
final class AuthToken
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var int
     */
    private $expires;
    /**
     * @var string
     */
    private $message;
    /**
     * @var int
     */
    private $code;
    /**
     * @var int
     */
    private $companyId;

    /**
     * AuthToken constructor.
     *
     * @param int    $code
     * @param string $message
     * @param string $token
     * @param int    $companyId
     * @param int    $expires
     */
    public function __construct(int $code, string $message, string $token, int $companyId, int $expires)
    {
        $this->setCode($code);
        $this->setMessage($message);
        $this->setToken($token);
        $this->setCompanyId($companyId);
        $this->setExpires($expires);
    }

    /**
     * @param int $code
     *
     * @return AuthToken
     */
    private function setCode(int $code): AuthToken
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return AuthToken
     */
    private function setMessage(string $message): AuthToken
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $token
     *
     * @return AuthToken
     */
    private function setToken(string $token): AuthToken
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param int $companyId
     *
     * @return AuthToken
     */
    private function setCompanyId(int $companyId): AuthToken
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * @param int $expires
     *
     * @return AuthToken
     */
    private function setExpires(int $expires): AuthToken
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    /**
     * @return int
     */
    public function getExpires(): int
    {
        return $this->expires;
    }
}