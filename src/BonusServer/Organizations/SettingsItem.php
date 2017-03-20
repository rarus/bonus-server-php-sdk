<?php
namespace Rarus\BonusServer\Organizations;

use Rarus\BonusServer\ApiClientInterface;

/**
 * Class SettingsItem
 *
 * @package Rarus\BonusServer\Organizations
 */
class SettingsItem implements SettingsItemInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $interfaceName;

    /**
     * SettingsItem constructor.
     *
     * @param $arSettingsItem
     */
    public function __construct($arSettingsItem)
    {
        $this->setName($arSettingsItem['name']);
        $this->setValue($arSettingsItem['value']);
        $this->setDescription($arSettingsItem['description']);
        $this->setInterfaceName($arSettingsItem['interface_name']);
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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    protected function setValue($value)
    {
        $this->value = $value;
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
    public function getInterfaceName()
    {
        return $this->interfaceName;
    }

    /**
     * @param string $interfaceName
     */
    protected function setInterfaceName($interfaceName)
    {
        $this->interfaceName = $interfaceName;
    }
}