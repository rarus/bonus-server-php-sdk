<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\Formatters;

use Rarus\BonusServer;

/**
 * Class UserFilter
 *
 * @package Rarus\BonusServer\Users\Formatters
 */
class UserFilter
{
    /**
     * @param BonusServer\Users\DTO\UserFilter $UserFilter
     *
     * @return string
     */
    public static function toUrlArguments(BonusServer\Users\DTO\UserFilter $UserFilter): string
    {
        $arFilter = [];
        if ($UserFilter->getGender()) {
            $arFilter['gender'] = $UserFilter->getGender()->getCode();
        }
        if ($UserFilter->isBlocked()) {
            $arFilter['is_locked'] = $UserFilter->isBlocked();
        }
        if ($UserFilter->isConfirmed()) {
            $arFilter['confirmed'] = $UserFilter->isConfirmed();
        }
        if ($UserFilter->getSearchValue() !== '') {
            $arFilter['user_filter'] = $UserFilter->getSearchValue();
        }
        if ($UserFilter->getLogin() !== '') {
            $arFilter['login'] = $UserFilter->getLogin();
        }

        return http_build_query($arFilter);
    }
}
