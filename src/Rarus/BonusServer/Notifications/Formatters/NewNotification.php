<?php

namespace Rarus\BonusServer\Notifications\Formatters;

final class NewNotification
{
    public static function toArray(\Rarus\BonusServer\Notifications\DTO\NewNotification $newNotification): array
    {
        return [
            'id'              => $newNotification->getNotificationId()->getId(),
            'title'           => $newNotification->getTitle(),
            'template_text'   => $newNotification->getTemplateText(),
            'user_id'         => $newNotification->getUserId() ? $newNotification->getUserId()->getId() : null,
            'card_id'         => $newNotification->getCardId() ? $newNotification->getCardId()->getId() : null,
            'start_date'      => $newNotification->getStartDate() ? $newNotification->getStartDate()->getTimestamp(
            ) : null,
            'expiration_date' => $newNotification->getExpirationDate() ? $newNotification->getExpirationDate(
            )->getTimestamp() : null
        ];
    }
}