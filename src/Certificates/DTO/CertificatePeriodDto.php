<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\DTO;

final class CertificatePeriodDto
{
    public function __construct(
        public ?int $daysBeforeActivation = null,
        public ?int $daysBeforeInvalidation = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['days_before_activation'] ?? null,
            $data['days_before_invalidation'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'days_before_activation' => $this->daysBeforeActivation,
            'days_before_invalidation' => $this->daysBeforeInvalidation,
        ];
    }
}
