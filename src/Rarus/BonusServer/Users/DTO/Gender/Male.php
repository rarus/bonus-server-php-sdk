<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\Gender;

/**
 * Class Male
 *
 * @package Rarus\BonusServer\Users\DTO\Gender
 */
class Male extends Gender
{
    /**
     * Male constructor.
     */
    public function __construct()
    {
        $this->setCode('male');
    }
}