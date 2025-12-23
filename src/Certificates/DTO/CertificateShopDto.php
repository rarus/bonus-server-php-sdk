<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\DTO;

final class CertificateShopDto
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['name'] ?? null
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
