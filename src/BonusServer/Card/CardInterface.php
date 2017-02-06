<?php
namespace Rarus\BonusServer\Card;

/**
 * Interface CardInt
 * @package Rarus\BonusServer\Card
 */
interface CardInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getMagCode();

    /**
     * @param string $magCode
     */
    public function setMagCode($magCode);

    /**
     * @return string
     */
    public function getBarCode();

    /**
     * @param string $barCode
     */
    public function setBarCode($barCode);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     */
    public function setDescription($description);

    /**
     * @return boolean
     */
    public function getBlockedStatus();

    /**
     * @param boolean $blocked
     */
    public function setBlockedStatus($blocked);

    /**
     * @return boolean
     */
    public function getActiveStatus();

    /**
     * @param boolean $active
     */
    public function setActiveStatus($active);

    /**
     * @return string
     */
    public function getBlockedDescription();

    /**
     * @param string $blockedDescription
     */
    public function setBlockedDescription($blockedDescription);

    /**
     * @return float
     */
    public function getBalance();

    /**
     * @param float $balance
     */
    public function setBalance($balance);

    /**
     * @return string
     */
    public function getDateActive();

    /**
     * @param string $dateActive
     */
    public function setDateActive($dateActive);

    /**
     * @return string
     */
    public function getDateDeactivate();

    /**
     * @param string $dateDeactivate
     */
    public function setDateDeactivate($dateDeactivate);

    /**
     * @return string
     */
    public function getDateLastTransaction();

    /**
     * @param string $dateLastTransaction
     */
    public function setDateLastTransaction($dateLastTransaction);

    /**
     * @return string
     */
    public function getLastTransaction();

    /**
     * @param string $lastTransaction
     */
    public function setLastTransaction($lastTransaction);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $image
     */
    public function setImage($image);
}