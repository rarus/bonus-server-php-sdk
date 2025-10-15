<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class CertificateGroupDto
{
    public function __construct(
        public ?int $certificateCount = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?bool $deleted = null,
        public ?string $description = null,
        /** @var CertificateShopDto[]|null */
        public ?array $excludeShops = null,
        public ?int $id = null,
        /** @var CertificateShopDto[]|null */
        public ?array $includeShops = null,
        public ?string $name = null,
        public ?int $parentId = null,
        public ?CertificatePeriodDto $period = null,
        public ?RefundStatus $refundStatus = RefundStatus::Default,
        public ?\DateTimeImmutable $salePeriodEnd = null,
        public ?\DateTimeImmutable $salePeriodStart = null,
        /** @var int[]|null */
        public ?array $shopsExcluded = null,
        /** @var int[]|null */
        public ?array $shopsIncluded = null,
        public ?SpendingType $spendingType = SpendingType::Full,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?UsageType $usage = UsageType::Reusable,
        public ?Money $worth = null,
        public ?WorthType $worthType = WorthType::Fixed,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @param Currency $currency
     * @param \DateTimeZone $dateTimeZone
     * @return self
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            $data['certificate_count'] ?? null,
            isset($data['created_at']) ? DateTimeParser::fromTimestamp($data['created_at'], $dateTimeZone) : null,
            $data['deleted'] ?? null,
            $data['description'] ?? null,
            isset($data['exclude_shops']) ? array_map(
                fn(array $s) => CertificateShopDto::fromArray($s),
                $data['exclude_shops']
            ) : null,
            $data['id'] ?? null,
            isset($data['include_shops']) ? array_map(
                fn(array $s) => CertificateShopDto::fromArray($s),
                $data['include_shops']
            ) : null,
            $data['name'] ?? null,
            $data['parent_id'] ?? null,
            isset($data['period']) ? CertificatePeriodDto::fromArray($data['period']) : null,
            isset($data['refund_status']) ? RefundStatus::from($data['refund_status']) : RefundStatus::Default,
            isset($data['sale_period_end']) ? DateTimeParser::fromTimestamp(
                $data['sale_period_end'],
                $dateTimeZone
            ) : null,
            isset($data['sale_period_start']) ? DateTimeParser::fromTimestamp(
                $data['sale_period_start'],
                $dateTimeZone
            ) : null,
            $data['shops_excluded'] ?? null,
            $data['shops_included'] ?? null,
            isset($data['spending_type']) ? SpendingType::from($data['spending_type']) : SpendingType::Full,
            isset($data['updated_at']) ? DateTimeParser::fromTimestamp($data['updated_at'], $dateTimeZone) : null,
            isset($data['usage']) ? UsageType::from($data['usage']) : UsageType::Reusable,
            isset($data['worth']) ? MoneyParser::parse($data['worth'], $currency) : null,
            isset($data['worth_type']) ? WorthType::from($data['worth_type']) : WorthType::Fixed,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'certificate_count' => $this->certificateCount,
            'created_at' => $this->createdAt?->format(DATE_ATOM),
            'deleted' => $this->deleted,
            'description' => $this->description,
            'exclude_shops' => $this->excludeShops ? array_map(
                fn(CertificateShopDto $s) => $s->toArray(),
                $this->excludeShops
            ) : null,
            'id' => $this->id,
            'include_shops' => $this->includeShops ? array_map(
                fn(CertificateShopDto $s) => $s->toArray(),
                $this->includeShops
            ) : null,
            'name' => $this->name,
            'parent_id' => $this->parentId,
            'period' => $this->period?->toArray(),
            'refund_status' => $this->refundStatus?->value,
            'sale_period_end' => $this->salePeriodEnd?->format(DATE_ATOM),
            'sale_period_start' => $this->salePeriodStart?->format(DATE_ATOM),
            'shops_excluded' => $this->shopsExcluded,
            'shops_included' => $this->shopsIncluded,
            'spending_type' => $this->spendingType?->value,
            'updated_at' => $this->updatedAt?->format(DATE_ATOM),
            'usage' => $this->usage?->value,
            'worth' => $this->worth ? MoneyParser::toString($this->worth) : null,
            'worth_type' => $this->worthType?->value,
        ];
    }
}
