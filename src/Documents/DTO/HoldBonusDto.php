<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class HoldBonusDto
{
    public function __construct(
        public Money $amount,
        public int $id,
        public ?bool $used = false,
    ) {}

    /**
     * @param  array<string>  $data
     */
    public static function fromArray(array $data, Currency $currency): self
    {
        return new self(
            amount: MoneyParser::parse($data['amount'], $currency),
            id: (int) $data['id'],
            used: (bool) ($data['used'] ?? false),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'amount' => MoneyParser::toString($this->amount),
            'id' => $this->id,
            'used' => $this->used,
        ];
    }
}
