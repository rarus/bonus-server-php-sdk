<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoCodes\DTO;

use DateTimeImmutable;
use DateTimeZone;
use Money\Currency;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final class HoldPromoCodeDto
{
    public function __construct(
        public ?int $cardId = null,
        public ?string $code = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?string $description = null,
        public ?HoldPromoCodeExpiresDto $expires = null,
        public ?DateTimeImmutable $expiresAt = null,
        public ?int $id = null,
        public ?HoldPromoCodeState $state = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            $data['card_id'] ?? null,
            $data['code'] ?? null,
            isset($data['created_at']) ? DateTimeParser::fromTimestamp($data['created_at'], $dateTimeZone) : null,
            $data['description'] ?? null,
            isset($data['expires']) ? HoldPromoCodeExpiresDto::fromArray($data['expires'], $dateTimeZone) : null,
            isset($data['expires_at']) ? DateTimeParser::fromTimestamp($data['expires_at'], $dateTimeZone) : null,
            $data['id'] ?? null,
            isset($data['state']) ? HoldPromoCodeState::from($data['state']) : null,
            isset($data['updated_at']) ? DateTimeParser::fromTimestamp($data['updated_at'], $dateTimeZone) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'card_id' => $this->cardId,
            'code' => $this->code,
            'created_at' => $this->createdAt?->format(DATE_ATOM),
            'description' => $this->description,
            'expires' => $this->expires?->toArray(),
            'expires_at' => $this->expiresAt?->format(DATE_ATOM),
            'id' => $this->id,
            'state' => $this->state?->value,
            'updated_at' => $this->updatedAt?->format(DATE_ATOM),
        ];
    }
}
