<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\Status;

/**
 *
 * Class UserStatus
 *
 * @package Rarus\BonusServer\Users\DTO\Status
 */
final class UserStatus
{
    /**
     * @var bool Признак блокировки юзера
     */
    private $isBlocked;
    /**
     * @var bool Принак, что пользователь подтвержен
     */
    private $isConfirmed;

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    /**
     * @param bool $isBlocked
     *
     * @return UserStatus
     */
    public function setIsBlocked(bool $isBlocked): UserStatus
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    /**
     * @param bool $isConfirmed
     *
     * @return UserStatus
     */
    public function setIsConfirmed(bool $isConfirmed): UserStatus
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }
}
