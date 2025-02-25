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
     * @param BonusServer\Users\DTO\UserFilter $userFilter
     *
     * @return string
     */
    public static function toUrlArguments(BonusServer\Users\DTO\UserFilter $userFilter): string
    {
        $arFilter = [];
        if ($userFilter->getGender()) {
            $arFilter['gender'] = $userFilter->getGender()->getCode();
        }
        if ($userFilter->isBlocked()) {
            $arFilter['is_locked'] = $userFilter->isBlocked();
        }
        if ($userFilter->isConfirmed()) {
            $arFilter['confirmed'] = $userFilter->isConfirmed();
        }
        if ($userFilter->getSearchValue() !== '') {
            $arFilter['user_filter'] = $userFilter->getSearchValue();
        }
        if ($userFilter->getLogin() !== '') {
            $arFilter['login'] = $userFilter->getLogin();
        }
        if ($userFilter->getEmail() !== '') {
            $arFilter['email'] = $userFilter->getEmail();
        }
        if ($userFilter->getPhone() !== '') {
            $arFilter['phone'] = $userFilter->getPhone();
        }
        if ($userFilter->isAdditionalFields()) {
            $arFilter['with_additional_fields'] = 'true';
        }

        return http_build_query($arFilter);
    }
}
