<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoСodes\DTO;

use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final class PromoCodePeriodContainer
{
    public function __construct(
        public ?\DateTimeImmutable $start = null,
        public ?\DateTimeImmutable $end = null
    ) {
    }

    /**
     * @param array<string, int> $data
     * @param \DateTimeZone $dateTimeZone
     * @return self
     * @throws ApiClientException
     */
    public static function fromArray(array $data, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            isset($data['start']) ? DateTimeParser::fromTimestamp($data['start'], $dateTimeZone) : null,
            isset($data['end']) ? DateTimeParser::fromTimestamp($data['end'], $dateTimeZone) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'start' => $this->start?->format(DATE_ATOM),
            'end' => $this->end?->format(DATE_ATOM),
        ];
    }
}
