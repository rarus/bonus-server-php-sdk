<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoCodes\DTO;

use DateTimeImmutable;
use DateTimeZone;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final class PromoCodeGroupDto
{
    public function __construct(
        public ?int $codesCount = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?bool $deleted = null,
        public ?string $description = null,
        public ?int $id = null,
        public ?string $name = null,
        public ?int $parentId = null,
        public ?PromoCodeGroupPeriodDto $period = null,
        public ?bool $personal = null,
        public ?bool $requireCard = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?PromoCodeUsage $usage = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, DateTimeZone $dateTimeZone): self
    {
        return new self(
            $data['codes_count'] ?? null,
            isset($data['created_at']) ? DateTimeParser::fromTimestamp($data['created_at'], $dateTimeZone) : null,
            $data['deleted'] ?? null,
            $data['description'] ?? null,
            $data['id'] ?? null,
            $data['name'] ?? null,
            $data['parent_id'] ?? null,
            isset($data['period']) ? PromoCodeGroupPeriodDto::fromArray($data['period'], $dateTimeZone) : null,
            $data['personal'] ?? null,
            $data['require_card'] ?? null,
            isset($data['updated_at']) ? DateTimeParser::fromTimestamp($data['updated_at'], $dateTimeZone) : null,
            isset($data['usage']) ? PromoCodeUsage::from($data['usage']) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'codes_count' => $this->codesCount,
            'created_at' => $this->createdAt?->format(DATE_ATOM),
            'deleted' => $this->deleted,
            'description' => $this->description,
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parentId,
            'period' => $this->period?->toArray(),
            'personal' => $this->personal,
            'require_card' => $this->requireCard,
            'updated_at' => $this->updatedAt?->format(DATE_ATOM),
            'usage' => $this->usage?->value,
        ];
    }
}
