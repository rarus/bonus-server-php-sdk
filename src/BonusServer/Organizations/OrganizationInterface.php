<?php
namespace Rarus\BonusServer\Organizations;


/**
 * Class Organization
 *
 * @package Rarus\BonusServer\Organizations
 */
interface OrganizationInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getShortDescription();

    /**
     * @return string
     */
    public function getFullDescription();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getPhone();
}