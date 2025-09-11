<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Holds\DTO;

use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final class HoldBonusExpiresDto
{
    public function __construct(
        public ?\DateTimeImmutable $date = null,
        public ?HoldBonusPeriod $period = null,
        public ?int $value = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            isset($data['date']) ? DateTimeParser::fromTimestamp($data['date'], $dateTimeZone) : null,
            isset($data['period']) ? HoldBonusPeriod::from($data['period']) : null,
            $data['value'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'date' => $this->date?->format(DATE_ATOM),
            'period' => $this->period?->value,
            'value' => $this->value,
        ];
    }
}
