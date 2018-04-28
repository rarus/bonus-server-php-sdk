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
     * Credentials constructor.
     *
     * @param string      $login
     * @param string      $shaPassword
     * @param string      $role
     * @param string|null $session
     */
    public function __construct(string $login, string $shaPassword, string $role, string $session = null)
    {
        $this->login = $login;
        $this->password = $shaPassword;
        $this->role = $role;
        $this->session = $session;
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