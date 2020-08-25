<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\Gender;

/**
 * Class None
 *
 * @package Rarus\BonusServer\Users\DTO\Gender
 */
class None extends Gender
{
    /**
     * Male constructor.
     */
    public function __construct()
    {
        $this->setCode('none');
    }
}
