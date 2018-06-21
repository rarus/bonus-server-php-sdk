<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\Gender;

/**
 * Class Gender
 *
 * @package Rarus\BonusServer\Users\DTO\Gender
 */
abstract class Gender
{
    protected $code;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $genderCode
     */
    protected function setCode($genderCode): void
    {
        $this->code = $genderCode;
    }
}