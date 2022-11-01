<?php

namespace Rarus\BonusServer\Notifications\DTO;

class NotificationUserFilter
{
    /**
     * @var bool
     */
    private $expired = false;

    /**
     * @var \DateTime|null
     */
    private $from;

    /**
     * @param bool $expired
     *
     * @return NotificationUserFilter
     */
    public function setExpired(bool $expired): NotificationUserFilter
    {
        $this->expired = $expired;
        return $this;
    }

    /**
     * @param \DateTime|null $from
     *
     * @return NotificationUserFilter
     */
    public function setFrom(?\DateTime $from): NotificationUserFilter
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expired;
    }

    /**
     * @return \DateTime|null
     */
    public function getFrom(): ?\DateTime
    {
        return $this->from;
    }

}