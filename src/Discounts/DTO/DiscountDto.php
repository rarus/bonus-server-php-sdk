<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Discounts\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class DiscountDto
{
    public function __construct(
        public ?bool $excludeTurnoverAccumulation = false,
        public ?\DateTimeImmutable $from = null,
        public ?int $id = null,
        public ?string $name = null,
        public ?bool $once = false,
        public ?float $percent = null,
        public ?\DateTimeImmutable $to = null,
        public ?DiscountType $type = null,
        public ?Money $value = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            excludeTurnoverAccumulation: $data['exclude_turnover_accumulation'] ?? false,
            from: isset($data['from']) ? DateTimeParser::fromTimestamp($data['from'], $dateTimeZone) : null,
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            once: $data['once'] ?? false,
            percent: $data['percent'] ?? null,
            to: isset($data['to']) ? DateTimeParser::fromTimestamp($data['to'], $dateTimeZone) : null,
            type: DiscountType::from($data['type']),
            value: isset($data['value']) ? MoneyParser::parse($data['value'], $currency) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'exclude_turnover_accumulation' => $this->excludeTurnoverAccumulation ?? false,
            'from' => $this->from ? DateTimeParser::toTimestamp($this->from) : null,
            'id' => $this->id ?? null,
            'name' => $this->name ?? null,
            'once' => $this->once ?? false,
            'percent' => $this->percent ?? null,
            'to' => $this->to ? DateTimeParser::toTimestamp($this->to) : null,
            'type' => $this->type?->value,
            'value' => $this->value ? MoneyParser::toString($this->value) : null,
        ];
    }
}
