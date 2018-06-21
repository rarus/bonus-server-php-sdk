<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\PersonalInfo;

use Rarus\BonusServer\Users\DTO\Gender\Gender;

/**
 * Class PersonalInfo
 *
 * @package Rarus\BonusServer\Users\DTO\PersonalInfo
 */
final class PersonalInfo
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $email;
    /**
     * @var Gender|null
     */
    private $gender;
    /**
     * @var \DateTime|null
     */
    private $birthday;
    /**
     * @var string|null
     */
    private $image;
    /**
     * @var bool
     */
    private $receiveNotifications;

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return PersonalInfo
     */
    public function setImage(?string $image): PersonalInfo
    {
        $this->image = $image;

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
     * @return PersonalInfo
     */
    public function setName(string $name): PersonalInfo
    {
        $this->name = $name;

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
     * @return PersonalInfo
     */
    public function setPhone(string $phone): PersonalInfo
    {
        $this->phone = $phone;

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
     * @return PersonalInfo
     */
    public function setEmail(string $email): PersonalInfo
    {
        $this->email = $email;

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
     * @return PersonalInfo
     */
    public function setGender(Gender $gender): PersonalInfo
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     *
     * @return PersonalInfo
     */
    public function setBirthday(\DateTime $birthday): PersonalInfo
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReceiveNotifications(): bool
    {
        return $this->receiveNotifications;
    }

    /**
     * @param bool $receiveNotifications
     *
     * @return PersonalInfo
     */
    public function setReceiveNotifications(bool $receiveNotifications): PersonalInfo
    {
        $this->receiveNotifications = $receiveNotifications;

        return $this;
    }
}