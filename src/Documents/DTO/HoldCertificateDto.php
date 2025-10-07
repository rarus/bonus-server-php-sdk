<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class HoldCertificateDto
{
    public function __construct(
        public int $id,
        public ?Money $amount = null,
        public ?bool $used = false,
    ) {
    }

    /**
     * @param array<string> $data
     */
    public static function fromArray(array $data, Currency $currency): self
    {
        return new self(
            id: (int)$data['id'],
            amount: isset($data['amount']) ? MoneyParser::parse($data['amount'], $currency) : null,
            used: (bool)($data['used'] ?? false),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount instanceof Money ? MoneyParser::toString($this->amount) : null,
            'id' => $this->id,
            'used' => $this->used,
        ];
    }
}
