<?php

declare(strict_types=1);

namespace RarusBonus\Auth\DTO;

use RarusBonus\Exceptions\ApiClientException;
use RarusBonus\Util\DateTimeParser;

final readonly class AuthToken
{
    public function __construct(
        public string $token,
        public \DateTimeImmutable $expires
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            (string) $data['content'],
            DateTimeParser::fromTimestamp($data['expire_at'], $dateTimeZone)
        );
    }

    public function isExpired(): bool
    {
        return $this->expires < new \DateTimeImmutable;
    }

    public function getTtl(): int
    {
        return $this->expires->getTimestamp() - time();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'content' => $this->token,
            'expire_at' => $this->expires->getTimestamp(),
        ];
    }
}
