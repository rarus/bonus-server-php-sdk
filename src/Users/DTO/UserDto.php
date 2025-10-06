<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Users\DTO;

use DateTimeImmutable;
use DateTimeZone;
use Money\Currency;
use Rarus\LMS\SDK\Cards\DTO\CardDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Users\DTO\UserProperty\UserProperty;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final readonly class UserDto
{
    /**
     * @param  array<CardDto>|null  $cards
     * @param  array<UserProperty>|null  $properties
     */
    public function __construct(
        public string $name,
        public string $phone,
        public ?string $shopId = null,
        public ?UserCityDto $city = null,
        public ?int $id = null,
        public ?DateTimeImmutable $birthday = null,
        public ?Gender $gender = Gender::Other,
        public ?string $email = null,
        public ?string $channel = null,
        public ?bool $personalDataAccepted = true,
        public ?DateTimeImmutable $personalDataAcceptedDate = null,
        public ?bool $receiveNewslettersAccepted = null,
        public ?string $referrer = null,
        public ?DateTimeZone $timezone = new DateTimeZone('UTC'),
        public ?UserStatus $state = UserStatus::Confirmed,
        public ?DateTimeImmutable $dateConfirmed = null,
        public ?bool $blocked = false,
        public ?DateTimeImmutable $dateBlocked = null,
        public ?array $cards = null,
        public ?DateTimeImmutable $dateState = null,
        public ?string $externalId = null,
        public ?string $login = null,
        public ?string $password = null,
        public ?array $properties = null,
        public ?int $defaultCardId = null,
    ) {}

    /**
     * Creates an instance of the class from an array of data.
     *
     * @param  array<string, mixed>  $data  The array containing data to initialize the instance.
     * @param  DateTimeZone  $dateTimeZone  The timezone to be used when parsing date and time fields.
     * @return self Returns a new instance of the class.
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            name: $data['name'],
            phone: $data['phone'],
            shopId: isset($data['shop']['id'])
                ? (string) $data['shop']['id']
                : (isset($data['shop_id']) ? (string) $data['shop_id'] : null),
            city: isset($data['city']) ? UserCityDto::fromArray($data['city']) : null,
            id: isset($data['id']) ? (int) $data['id'] : null,
            birthday: isset($data['birthday']) ? DateTimeParser::fromTimestamp(
                $data['birthday'],
                $dateTimeZone
            ) : null,
            gender: isset($data['gender']) ? Gender::from($data['gender']) : null,
            email: $data['email'] ?? null,
            channel: $data['channel'] ?? null,
            personalDataAccepted: (bool) ($data['personal_data_accepted'] ?? false),
            personalDataAcceptedDate: isset($data['personal_data_accepted_date']) ? DateTimeParser::fromTimestamp(
                $data['personal_data_accepted_date'],
                $dateTimeZone
            ) : null,
            receiveNewslettersAccepted: isset($data['receive_newsletters_accepted']) ?
                (bool) ($data['receive_newsletters_accepted']) : null,
            referrer: isset($data['referrer']['phone']) ? (string) $data['referrer']['phone'] : null,
            timezone: DateTimeParser::timeZoneFromString($data['timezone'] ?? null),
            state: isset($data['state']) ? UserStatus::from($data['state']) : null,
            dateConfirmed: isset($data['date_confirmed']) ? DateTimeParser::fromTimestamp(
                $data['date_confirmed'],
                $dateTimeZone
            ) : null,
            blocked: (bool) ($data['blocked'] ?? false),
            dateBlocked: isset($data['date_blocked']) ? DateTimeParser::fromTimestamp(
                $data['date_blocked'],
                $dateTimeZone
            ) : null,
            cards: empty($data['cards']) ? null : array_map(
                fn (array $row): CardDto => CardDto::fromArray($row, $currency, $dateTimeZone),
                $data['cards']
            ),
            dateState: isset($data['date_state']) ? DateTimeParser::fromTimestamp(
                $data['date_state'],
                $dateTimeZone
            ) : null,
            externalId: empty($data['external_id']['id']) ? null : (string) $data['external_id']['id'],
            login: $data['login'] ?? null,
            password: $data['password'] ?? null,
            properties: empty($data['properties']) ? null : array_map(
                fn (array $row): UserProperty => UserProperty::fromArray($row, $dateTimeZone),
                $data['properties']
            ),
            defaultCardId: $data['default_card_id'] ?? null
        );
    }

    /**
     * Converts the current object instance into an associative array representation.
     *
     * @return array<string, mixed> Associative array containing the object's properties as key-value pairs.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'shop_id' => $this->shopId,
            'city' => $this->city?->name,
            'city_id' => $this->city?->id,
            'id' => $this->id,
            'birthday' => $this->birthday instanceof DateTimeImmutable ? DateTimeParser::toTimestamp($this->birthday) : null,
            'gender' => $this->gender?->value,
            'email' => $this->email,
            'channel' => $this->channel,
            'personal_data_accepted' => $this->personalDataAccepted,
            'personal_data_accepted_date' => $this->personalDataAcceptedDate instanceof DateTimeImmutable ? DateTimeParser::toTimestamp(
                $this->personalDataAcceptedDate
            ) : null,
            'receive_newsletters_accepted' => $this->receiveNewslettersAccepted,
            'referrer' => $this->referrer,
            'timezone' => $this->timezone?->getName(),
            'state' => $this->state?->value,
            'date_confirmed' => $this->dateConfirmed instanceof DateTimeImmutable ? DateTimeParser::toTimestamp($this->dateConfirmed) : null,
            'blocked' => $this->blocked,
            'date_blocked' => $this->dateBlocked instanceof DateTimeImmutable ? DateTimeParser::toTimestamp($this->dateBlocked) : null,
            'cards' => $this->cards !== null && $this->cards !== [] ? array_map(fn (CardDto $cardDto): array => $cardDto->toArray(), $this->cards)
                : null,
            'date_state' => $this->dateState instanceof DateTimeImmutable ? DateTimeParser::toTimestamp($this->dateState) : null,
            'external_id' => $this->externalId,
            'login' => $this->login,
            'password' => $this->password,
            'properties' => $this->properties !== null && $this->properties !== [] ? array_map(fn (UserProperty $userProperty): array => $userProperty->toArray(),
                $this->properties) : null,
            'default_card_id' => $this->defaultCardId,
        ];
    }
}
