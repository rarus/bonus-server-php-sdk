<?php

namespace Rarus\BonusServer\Notifications\DTO;

class NotificationOrganizationFilter
{
    /**
     * @var \Rarus\BonusServer\Notifications\DTO\NotificationId|null
     */
    private $notificationId;
    /**
     * @var \DateTime|null
     */
    private $from;
    /**
     * @var \DateTime|null
     */
    private $expired;
    /**
     * @var \Rarus\BonusServer\Users\DTO\UserId|null
     */
    private $userId;
    /**
     * @var \Rarus\BonusServer\Cards\DTO\CardId|null
     */
    private $cardId;

    /**
     * @param \Rarus\BonusServer\Notifications\DTO\NotificationId|null $notificationId
     *
     * @return NotificationOrganizationFilter
     */
    public function setNotificationId(?NotificationId $notificationId): NotificationOrganizationFilter
    {
        $this->notificationId = $notificationId;
        return $this;
    }

    /**
     * @param \DateTime|null $from
     *
     * @return NotificationOrganizationFilter
     */
    public function setFrom(?\DateTime $from): NotificationOrganizationFilter
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param \DateTime|null $expired
     *
     * @return NotificationOrganizationFilter
     */
    public function setExpired(?\DateTime $expired): NotificationOrganizationFilter
    {
        $this->expired = $expired;
        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Users\DTO\UserId|null $userId
     *
     * @return NotificationOrganizationFilter
     */
    public function setUserId(?\Rarus\BonusServer\Users\DTO\UserId $userId): NotificationOrganizationFilter
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Cards\DTO\CardId|null $cardId
     *
     * @return NotificationOrganizationFilter
     */
    public function setCardId(?\Rarus\BonusServer\Cards\DTO\CardId $cardId): NotificationOrganizationFilter
    {
        $this->cardId = $cardId;
        return $this;
    }

    /**
     * @return \Rarus\BonusServer\Notifications\DTO\NotificationId|null
     */
    public function getNotificationId(): ?NotificationId
    {
        return $this->notificationId;
    }

    /**
     * @return \DateTime|null
     */
    public function getFrom(): ?\DateTime
    {
        return $this->from;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpired(): ?\DateTime
    {
        return $this->expired;
    }

    /**
     * @return \Rarus\BonusServer\Users\DTO\UserId|null
     */
    public function getUserId(): ?\Rarus\BonusServer\Users\DTO\UserId
    {
        return $this->userId;
    }

    /**
     * @return \Rarus\BonusServer\Cards\DTO\CardId|null
     */
    public function getCardId(): ?\Rarus\BonusServer\Cards\DTO\CardId
    {
        return $this->cardId;
    }
}