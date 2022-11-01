<?php

namespace Rarus\BonusServer\Notifications\DTO;

class NewNotification
{
    /**
     * @var \Rarus\BonusServer\Notifications\DTO\NotificationId
     */
    private $notificationId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $templateText;
    /**
     * @var \Rarus\BonusServer\Cards\DTO\CardId|null
     */
    private $cardId;
    /**
     * @var \Rarus\BonusServer\Users\DTO\UserId|null
     */
    private $userId;
    /**
     * @var \DateTime|null
     */
    private $startDate;
    /**
     * @var \DateTime|null
     */
    private $expirationDate;

    /**
     * @param \Rarus\BonusServer\Notifications\DTO\NotificationId $notificationId
     * @param string                                              $title
     * @param string                                              $templateText
     */
    public function __construct(NotificationId $notificationId, string $title, string $templateText)
    {
        $this->notificationId = $notificationId;
        $this->title = $title;
        $this->templateText = $templateText;
    }

    /**
     * @param \Rarus\BonusServer\Cards\DTO\CardId|null $cardId
     *
     * @return NewNotification
     */
    public function setCardId(?\Rarus\BonusServer\Cards\DTO\CardId $cardId): NewNotification
    {
        $this->cardId = $cardId;
        return $this;
    }

    /**
     * @param \Rarus\BonusServer\Users\DTO\UserId|null $userId
     *
     * @return NewNotification
     */
    public function setUserId(?\Rarus\BonusServer\Users\DTO\UserId $userId): NewNotification
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param \DateTime|null $startDate
     *
     * @return NewNotification
     */
    public function setStartDate(?\DateTime $startDate): NewNotification
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @param \DateTime|null $expirationDate
     *
     * @return NewNotification
     */
    public function setExpirationDate(?\DateTime $expirationDate): NewNotification
    {
        $this->expirationDate = $expirationDate;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getTemplateText(): string
    {
        return $this->templateText;
    }

    /**
     * @return \Rarus\BonusServer\Cards\DTO\CardId|null
     */
    public function getCardId(): ?\Rarus\BonusServer\Cards\DTO\CardId
    {
        return $this->cardId;
    }

    /**
     * @return \Rarus\BonusServer\Users\DTO\UserId|null
     */
    public function getUserId(): ?\Rarus\BonusServer\Users\DTO\UserId
    {
        return $this->userId;
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
    public function getExpirationDate(): ?\DateTime
    {
        return $this->expirationDate;
    }
}