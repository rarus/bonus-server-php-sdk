<?php

namespace Rarus\BonusServer\Notifications\DTO;

class Notification
{
    /**
     * @var \Rarus\BonusServer\Notifications\DTO\NotificationId
     */
    private $notificationId;
    /**
     * @var string|null
     */
    private $title = null;
    /**
     * @var string|null
     */
    private $text = null;
    /**
     * @var \DateTime|null
     */
    private $startDate = null;
    /**
     * @var \DateTime|null
     */
    private $endDate = null;
    /**
     * @var bool
     */
    private $expired = false;
    /**
     * @var bool
     */
    private $read = false;
    /**
     * @var string|null
     */
    private $image = null;

    /**
     * @param \Rarus\BonusServer\Notifications\DTO\NotificationId $notificationId
     */
    public function __construct(NotificationId $notificationId)
    {
        $this->notificationId = $notificationId;
    }

    /**
     * @param string $title
     *
     * @return Notification
     */
    public function setTitle(string $title): Notification
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $text
     *
     * @return Notification
     */
    public function setText(string $text): Notification
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Notification
     */
    public function setStartDate(\DateTime $startDate): Notification
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return Notification
     */
    public function setEndDate(\DateTime $endDate): Notification
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param bool $expired
     *
     * @return Notification
     */
    public function setExpired(bool $expired): Notification
    {
        $this->expired = $expired;
        return $this;
    }

    /**
     * @param bool $read
     *
     * @return Notification
     */
    public function setRead(bool $read): Notification
    {
        $this->read = $read;
        return $this;
    }

    /**
     * @param string $image
     *
     * @return Notification
     */
    public function setImage(string $image): Notification
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return \Rarus\BonusServer\Notifications\DTO\NotificationId
     */
    public function getNotificationId(): NotificationId
    {
        return $this->notificationId;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expired;
    }

    /**
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->read;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
}