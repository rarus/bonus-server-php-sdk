<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Cards\DTO;

use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final readonly class SalesDto
{
    public function __construct(
        public \DateTimeImmutable $first,
        public \DateTimeImmutable $last,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'first' => DateTimeParser::toTimestamp($this->first),
            'last' => DateTimeParser::toTimestamp($this->last),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            DateTimeParser::fromTimestamp($data['first'], $dateTimeZone),
            DateTimeParser::fromTimestamp($data['last'], $dateTimeZone),
        );
    }
}
