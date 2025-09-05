<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Discounts\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class CertificatePaymentDto
{
    public function __construct(
        public Money $amount,
        public string $code,
    ) {
    }

    /**
     * @param array<string> $data
     * @param Currency $currency
     * @return CertificatePaymentDto
     */
    public static function fromArray(array $data, Currency $currency): CertificatePaymentDto
    {
        return new self(
            amount: MoneyParser::parse($data['amount'], $currency),
            code: (string)$data['code'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'amount' => MoneyParser::toString($this->amount),
            'code' => $this->code,
        ];
    }
}
