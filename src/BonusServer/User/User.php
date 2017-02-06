<?php
namespace Rarus\BonusServer\User;


class User implements UserInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $phone;
    /**
     * @var string
     */
    protected $birthdate;
    /**
     * @var string
     */
    protected $gender;
    /**
     * @var string
     */
    protected $receive_notifications;

    /**
     * User constructor
     *
     * @param $arUser
     */
    public function __construct($arUser)
    {
        $this->setName($arUser['name']);
        $this->setEmail($arUser['email']);
        $this->setPhone($arUser['phone']);
        $this->setBirthDate($arUser['birthdate']);
        $this->setGender($arUser['gender']);
        $this->setNotifications($arUser['receive_notifications']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    protected function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    protected function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthdate;
    }

    /**
     * @param string $birthdate
     */
    protected function setBirthDate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    protected function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getNotifications()
    {
        return $this->receive_notifications;
    }

    /**
     * @param string $receive_notifications
     */
    protected function setNotifications($receive_notifications)
    {
        $this->receive_notifications;
    }
}
