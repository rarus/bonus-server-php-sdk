<?php

namespace Rarus\BonusServer\Notifications\Transport\DTO;

use Rarus\BonusServer\Notifications\DTO\NotificationCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var \Rarus\BonusServer\Notifications\DTO\NotificationCollection
     */
    private $notificationCollection;

    /**
     * @param \Rarus\BonusServer\Notifications\DTO\NotificationCollection $notificationCollection
     */
    public function __construct(NotificationCollection $notificationCollection, Pagination $pagination)
    {
        $this->notificationCollection = $notificationCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return \Rarus\BonusServer\Notifications\DTO\NotificationCollection
     */
    public function getNotificationCollection(): NotificationCollection
    {
        return $this->notificationCollection;
    }
}
