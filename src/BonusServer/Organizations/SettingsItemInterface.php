<?php
namespace Rarus\BonusServer\Organizations;


/**
 * Class SettingsItem
 *
 * @package Rarus\BonusServer\Organizations
 */
interface SettingsItemInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getInterfaceName();
}