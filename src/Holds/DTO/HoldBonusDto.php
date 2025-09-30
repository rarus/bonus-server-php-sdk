<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Holds\DTO;

use DateTimeImmutable;
use DateTimeZone;
use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class HoldBonusDto
{
    public function __construct(
        public ?Money $amount = null,
        public ?int $cardId = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?string $description = null,
        public ?string $documentId = null,
        public ?Money $erased = null,
        public ?HoldBonusExpiresDto $expires = null,
        public ?DateTimeImmutable $expiresAt = null,
        public ?int $id = null,
        public ?HoldBonusState $state = null,
        public ?Money $unholded = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?Money $used = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            isset($data['amount']) ? MoneyParser::parse($data['amount'], $currency) : null,
            isset($data['card_id']) ? (int)$data['card_id'] : null,
            isset($data['created_at']) ? DateTimeParser::fromTimestamp($data['created_at'], $dateTimeZone) : null,
            $data['description'] ?? null,
            $data['document_id'] ?? null,
            isset($data['erased']) ? MoneyParser::parse($data['erased'], $currency) : null,
            isset($data['expires']) ? HoldBonusExpiresDto::fromArray($data['expires'], $dateTimeZone) : null,
            isset($data['expires_at']) ? DateTimeParser::fromTimestamp($data['expires_at'], $dateTimeZone) : null,
            $data['id'] ?? null,
            isset($data['state']) ? HoldBonusState::from($data['state']) : null,
            isset($data['unholded']) ? MoneyParser::parse($data['unholded'], $currency) : null,
            isset($data['updated_at']) ? DateTimeParser::fromTimestamp($data['updated_at'], $dateTimeZone) : null,
            isset($data['used']) ? MoneyParser::parse($data['used'], $currency) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount instanceof Money ? MoneyParser::toString($this->amount) : null,
            'card_id' => $this->cardId,
            'created_at' => $this->createdAt?->format(DATE_ATOM),
            'description' => $this->description,
            'document_id' => $this->documentId,
            'erased' => $this->erased instanceof Money ? MoneyParser::toString($this->erased) : null,
            'expires' => $this->expires?->toArray(),
            'expires_at' => $this->expiresAt?->format(DATE_ATOM),
            'id' => $this->id,
            'state' => $this->state?->value,
            'unholded' => $this->unholded instanceof Money ? MoneyParser::toString($this->unholded) : null,
            'updated_at' => $this->updatedAt?->format(DATE_ATOM),
            'used' => $this->used instanceof Money ? MoneyParser::toString($this->used) : null,
        ];
    }
}
