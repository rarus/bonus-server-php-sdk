<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoCodes\DTO;

use Rarus\LMS\SDK\Exceptions\ApiClientException;

final class PromoCodeGroupPeriodDto
{
    public function __construct(
        public ?PromoCodePeriodContainer $container = null,
        public ?PromoCodePeriodType $type = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            isset($data['container']) ? PromoCodePeriodContainer::fromArray($data['container'], $dateTimeZone) : null,
            isset($data['type']) ? PromoCodePeriodType::from($data['type']) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'container' => $this->container?->toArray(),
            'type' => $this->type?->value,
        ];
    }
}
