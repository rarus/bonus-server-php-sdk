<?php

namespace Rarus\BonusServer\Notifications\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Users\DTO\UserId;

class Fabric
{
    public static function initNotificationFromServerResponse(array $response): Notification
    {
        $notification = new Notification(new NotificationId($response['id']));

        if (!empty($response['title'])) {
            $notification->setTitle($response['title']);
        }

        if (!empty($response['text'])) {
            $notification->setText($response['text']);
        }

        if (!empty($response['start_date'])) {
            $notification->setStartDate((new \DateTime())->setTimestamp($response['start_date']));
        }

        if (!empty($response['expiration_date'])) {
            $notification->setEndDate((new \DateTime())->setTimestamp($response['expiration_date']));
        }

        if (!empty($response['expired'])) {
            $notification->setExpired((bool)$response['expired']);
        }

        if (!empty($response['read'])) {
            $notification->setRead((bool)$response['read']);
        }

        if (!empty($response['image'])) {
            $notification->setImage($response['image']);
        }

        return $notification;
    }

    public static function initNewNotificationFromServerResponse(array $response): NewNotification
    {
        $notification = new NewNotification(new NotificationId($response['id']), $response['title'], $response['template_text']);

        if (!empty($response['start_date'])) {
            $notification->setStartDate((new \DateTime())->setTimestamp($response['start_date']));
        }

        if (!empty($response['expiration_date'])) {
            $notification->setExpirationDate((new \DateTime())->setTimestamp($response['expiration_date']));
        }

        if (!empty($response['user_id'])) {
            $notification->setUserId(new UserId($response['user_id']));
        }

        if (!empty($response['card_id'])) {
            $notification->setCardId(new CardId($response['user_id']));
        }

        return $notification;
    }
}