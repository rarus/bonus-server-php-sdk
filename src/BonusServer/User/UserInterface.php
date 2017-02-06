<?php
namespace Rarus\BonusServer\User;


/**
 * Interface UserInterface
 * @package Rarus\BonusServer\User
 */
interface UserInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @return string
     */
    public function getBirthDate();

    /**
     * @return string
     */
    public function getGender();

    /**
     * @return string
     */
    public function getNotifications();
}