<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO;

use Rarus\BonusServer\Users\DTO\Gender\Gender;

/**
 * DTO объект сущности "Пользователь"
 *
 * Class Users
 *
 * @package Rarus\BonusServer\Users\DTO
 */
final class User
{
    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var string|null Логин пользоватля
     */
    private $login;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string email пользователя
     */
    private $email;
    /**
     * @var string телефон пользователя
     */
    private $phone;
    /**
     * @var \DateTime
     */
    private $birthdate;
    /**
     * @var Gender
     */
    private $gender;
    /**
     * @var string Ссылка изображению польовтеля
     */
    private $imageUrl;
    /**
     * @var Status\UserStatus
     */
    private $status;

    /**
     * @return Status\UserStatus
     */
    public function getStatus(): Status\UserStatus
    {
        return $this->status;
    }

    /**
     * @param Status\UserStatus $status
     *
     * @return User
     */
    public function setStatus(Status\UserStatus $status): User
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @param UserId $userId
     *
     * @return User
     */
    public function setUserId(UserId $userId): User
    {
        $this->userId = $userId;

        return $this;
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
     *
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return User
     */
    public function setPhone(string $phone): User
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate(\DateTime $birthdate): User
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Gender|null
     */
    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender $gender
     *
     * @return User
     */
    public function setGender(Gender $gender): User
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     *
     * @return User
     */
    public function setImageUrl(string $imageUrl): User
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
