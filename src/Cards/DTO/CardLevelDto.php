<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Cards\DTO;

final readonly class CardLevelDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function createFromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (string) $data['name'],
        );
    }
}
