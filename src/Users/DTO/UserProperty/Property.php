<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Users\DTO\UserProperty;

use DateTimeImmutable;
use DateTimeZone;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final readonly class Property
{
    /**
     * @param array<string>|array<int> $values
     */
    public function __construct(
        public int $id,
        public string $externalId,
        public string $name,
        public UserPropertyType $type,
        public bool $usePredefinedValue,
        public array $values,
        public bool $deleted,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @throws ApiClientException
     */
    public static function fromArray(array $data, DateTimeZone $dateTimeZone): self
    {
        return new self(
            id: (int)$data['id'],
            externalId: (string)$data['external_id'],
            name: (string)$data['name'],
            type: UserPropertyType::from($data['type']),
            usePredefinedValue: (bool)$data['use_predefined_value'],
            values: $data['valid_values'] ?? [],
            deleted: (bool)$data['deleted'],
            createdAt: DateTimeParser::fromTimestamp($data['created_at'], $dateTimeZone),
            updatedAt: DateTimeParser::fromTimestamp($data['updated_at'], $dateTimeZone),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'external_id' => $this->externalId,
            'name' => $this->name,
            'type' => $this->type->value,
            'use_predefined_value' => $this->usePredefinedValue,
            'values' => $this->values,
            'deleted' => $this->deleted,
            'created_at' => $this->createdAt->format(DATE_ATOM),
            'updated_at' => $this->updatedAt->format(DATE_ATOM),
        ];
    }
}
