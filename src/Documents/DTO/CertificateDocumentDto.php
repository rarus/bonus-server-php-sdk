<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class CertificateDocumentDto
{
    public function __construct(
        public Money $balance,
        public string $code,
    ) {}

    /**
     * @param  array<string>  $data
     */
    public static function fromArray(array $data, Currency $currency): self
    {
        return new self(
            balance: MoneyParser::parse($data['balance'], $currency),
            code: (string) $data['code'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'balance' => MoneyParser::toString($this->balance),
            'code' => $this->code,
        ];
    }
}
