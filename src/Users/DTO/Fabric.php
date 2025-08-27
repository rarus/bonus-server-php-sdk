<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Users\DTO;

use DateTimeZone;
use Rarus\LMS\SDK\Cards\DTO\CardDto;
use Rarus\LMS\SDK\Users\DTO\UserProperty\UserProperty;

class Fabric
{
    /**
     * Создание объекта нового пользователя
     *
     * @param  array<CardDto>|null  $cards
     * @param  array<UserProperty>  $properties
     */
    public static function createNewInstance(
        string $name,
        string $phone,
        int $shopId,
        ?string $email = null,
        ?Gender $gender = Gender::Other,
        ?\DateTimeImmutable $birthday = null,
        int|string|null $userId = null,
        ?array $cards = null,
        ?string $channel = null,
        ?string $login = null,
        ?bool $personalDataAccepted = false,
        ?array $properties = null,
        ?bool $receiveNewslettersAccepted = false,
        ?string $referrer = null,
        ?UserStatus $state = UserStatus::Confirmed,
        ?string $password = null,
        ?DateTimeZone $timezone = null,
    ): UserDto {
        return new UserDto(
            name: $name,
            phone: $phone,
            shopId: $shopId,
            id: null,
            birthday: $birthday,
            gender: $gender,
            email: $email,
            channel: $channel,
            personalDataAccepted: (bool) $personalDataAccepted,
            personalDataAcceptedDate: null,
            receiveNewslettersAccepted: (bool) $receiveNewslettersAccepted,
            referrer: $referrer,
            timezone: $timezone ?? new \DateTimeZone('Europe/Moscow'),
            state: $state ?? UserStatus::Confirmed,
            dateConfirmed: null,
            blocked: false,
            dateBlocked: null,
            cards: $cards,
            dateState: null,
            externalId: $userId !== null ? (string) $userId : null,
            login: $login,
            password: $password,
            properties: $properties,
            defaultCardId: null
        );
    }
}
