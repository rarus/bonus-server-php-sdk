<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class PaymentDto
{
    public function __construct(
        public Money $amount,
        public ?PaymentType $type = PaymentType::Cash,
    ) {}

    /**
     * @param  array<string>  $data
     */
    public static function fromArray(array $data, Currency $currency): self
    {
        return new self(
            amount: MoneyParser::parse($data['amount'], $currency),
            type: PaymentType::from($data['type']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'amount' => MoneyParser::toString($this->amount),
            'type' => $this->type?->value,
        ];
    }
}
