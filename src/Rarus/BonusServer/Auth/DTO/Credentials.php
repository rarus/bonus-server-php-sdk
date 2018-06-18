<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Auth\DTO;

/**
 * Class Credentials
 *
 * @package Rarus\BonusServer\Auth\DTO
 */
final class Credentials
{
    /**
     * Логин пользователя
     *
     * @var string
     */
    private $login;
    /**
     * Пароль пользователя
     *
     * @var string
     */
    private $password;
    /**
     * Роль ользователя
     *
     * @var string
     */
    private $role;
    /**
     * @var string|null
     */
    private $session;
    /**
     * @var int|null
     */
    private $companyId;

    /**
     * Credentials constructor.
     *
     * @param string      $login
     * @param string      $shaPassword
     * @param string      $role
     * @param string|null $session
     * @param int|null    $companyId
     */
    public function __construct(string $login, string $shaPassword, string $role, string $session = null, ?int $companyId)
    {
        $this->login = $login;
        $this->password = $shaPassword;
        $this->role = $role;
        $this->session = $session;
        $this->companyId = $companyId;
    }

    /**
     * @return int|null
     */
    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    /**
     * @return null|string
     */
    public function getSession(): ?string
    {
        return $this->session;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }
}