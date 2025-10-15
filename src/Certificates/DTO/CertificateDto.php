<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\DTO;

use DateTimeZone;
use Money\Currency;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final class CertificateDto
{
    public function __construct(
        public ?string $code = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?bool $deleted = null,
        public ?CertificateGroupDto $group = null,
        public ?int $parentId = null,
        public ?CertificateStatusDto $status = null,
        public ?\DateTimeImmutable $updatedAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @param Currency $currency
     * @param DateTimeZone $dateTimeZone
     * @return self
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            $data['code'] ?? null,
            isset($data['created_at']) ? DateTimeParser::fromTimestamp($data['created_at'], $dateTimeZone) : null,
            $data['deleted'] ?? null,
            isset($data['group']) ? CertificateGroupDto::fromArray($data['group'], $currency, $dateTimeZone) : null,
            $data['parent_id'] ?? null,
            isset($data['status']) ? CertificateStatusDto::fromArray($data['status'], $currency, $dateTimeZone) : null,
            isset($data['updated_at']) ? DateTimeParser::fromTimestamp($data['updated_at'], $dateTimeZone) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'created_at' => $this->createdAt?->format(DATE_ATOM),
            'deleted' => $this->deleted,
            'group' => $this->group?->toArray(),
            'parent_id' => $this->parentId,
            'status' => $this->status?->toArray(),
            'updated_at' => $this->updatedAt?->format(DATE_ATOM),
        ];
    }
}
