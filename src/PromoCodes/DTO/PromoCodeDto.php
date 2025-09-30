<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoCodes\DTO;

use DateTimeImmutable;
use DateTimeZone;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final class PromoCodeDto
{
    public function __construct(
        public ?DateTimeImmutable $activeFrom = null,
        public ?DateTimeImmutable $activeTo = null,
        public ?string $code = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?bool $deleted = null,
        public ?PromoCodeGroupDto $group = null,
        public ?int $parentId = null,
        public ?PromoCodeStatus $status = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?int $usages = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, DateTimeZone $dateTimeZone): self
    {
        return new self(
            isset($data['active_from']) ? DateTimeParser::fromTimestamp($data['active_from'], $dateTimeZone) : null,
            isset($data['active_to']) ? DateTimeParser::fromTimestamp($data['active_to'], $dateTimeZone) : null,
            $data['code'] ?? null,
            isset($data['created_at']) ? DateTimeParser::fromTimestamp($data['created_at'], $dateTimeZone) : null,
            $data['deleted'] ?? null,
            isset($data['group']) ? PromoCodeGroupDto::fromArray($data['group'], $dateTimeZone) : null,
            $data['parent_id'] ?? null,
            isset($data['status']) ? PromoCodeStatus::from($data['status']) : null,
            isset($data['updated_at']) ? DateTimeParser::fromTimestamp($data['updated_at'], $dateTimeZone) : null,
            $data['usages'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'active_from' => $this->activeFrom?->format(DATE_ATOM),
            'active_to' => $this->activeTo?->format(DATE_ATOM),
            'code' => $this->code,
            'created_at' => $this->createdAt?->format(DATE_ATOM),
            'deleted' => $this->deleted,
            'group' => $this->group?->toArray(),
            'parent_id' => $this->parentId,
            'status' => $this->status?->value,
            'updated_at' => $this->updatedAt?->format(DATE_ATOM),
            'usages' => $this->usages,
        ];
    }
}
