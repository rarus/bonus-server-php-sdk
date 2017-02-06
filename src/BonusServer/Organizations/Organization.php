<?php
namespace Rarus\BonusServer\Organizations;

/**
 * Class Organization
 *
 * @package Rarus\BonusServer\Organizations
 */
class Organization implements OrganizationInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $shortDescription;

    /**
     * @var string
     */
    protected $fullDescription;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * Organization constructor.
     *
     * @param $arOrganization
     */
    public function __construct($arOrganization)
    {
        $this->setName($arOrganization['name']);
        $this->setShortDescription($arOrganization['short_description']);
        $this->setFullDescription($arOrganization['full_description']);
        $this->setDescription($arOrganization['description']);
        $this->setEmail($arOrganization['email']);
        $this->setPhone($arOrganization['phone']);
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
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    protected function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getFullDescription()
    {
        return $this->fullDescription;
    }

    /**
     * @param string $fullDescription
     */
    protected function setFullDescription($fullDescription)
    {
        $this->fullDescription = $fullDescription;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    protected function setDescription($description)
    {
        $this->description = $description;
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
}