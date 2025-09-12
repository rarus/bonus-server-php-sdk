<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class CertificatePaymentDto
{
    public function __construct(
        public ?Money $amount = null,
        public ?string $code = null,
    ) {}

    /**
     * @param  array<string>  $data
     */
    public static function fromArray(array $data, Currency $currency): CertificatePaymentDto
    {
        return new self(
            amount: isset($data['amount']) ? MoneyParser::parse($data['amount'], $currency) : null,
            code: $data['code'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount ? MoneyParser::toString($this->amount) : null,
            'code' => $this->code ?? null,
        ];
    }
}
