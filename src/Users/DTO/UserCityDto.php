<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Users\DTO;

use DateTimeZone;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

final class UserCityDto
{
    public function __construct(
        public string $name,
        public ?int $id = null,
        public ?DateTimeZone $timezone = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? $data['city'] ?? $data['city_name'],
            id: $data['id'] ?? null,
            timezone: DateTimeParser::timeZoneFromString($data['timezone'] ?? null),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'timezone' => $this->timezone?->getName(),
        ];
    }
}
