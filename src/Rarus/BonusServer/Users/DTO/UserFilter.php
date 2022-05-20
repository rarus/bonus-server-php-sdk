<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO;

use Rarus\BonusServer\Users\DTO\Gender\Gender;

/**
 * Class UserFilter для фильтрации пользователей
 *
 * @package Rarus\BonusServer\Users\DTO
 */
class UserFilter
{
    /**
     * @var Gender|null
     */
    protected $gender;
    /**
     * @var bool|null
     */
    protected $isBlocked;
    /**
     * @var bool|null
     */
    protected $isConfirmed;
    /**
     * @var string|null
     */
    protected $searchValue;
    /**
     * @var string|null
     */
    protected $login;
    /**
     * @var string|null
     */
    protected $email;
    /**
     * @var string|null
     */
    protected $phone;

    /**
     * @return Gender
     */
    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender $gender
     */
    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return bool|null
     */
    public function isBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(): void
    {
        $this->isBlocked = true;
    }

    /**
     * @return bool|null
     */
    public function isConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(): void
    {
        $this->isConfirmed = true;
    }

    /**
     * @return string|null
     */
    public function getSearchValue(): ?string
    {
        return $this->searchValue;
    }

    /**
     * @param string|null $searchValue
     */
    public function setSearchValue(?string $searchValue): void
    {
        $this->searchValue = $searchValue;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
}
